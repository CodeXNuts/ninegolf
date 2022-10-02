<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway\Stripe;
use App\Models\UserStripeConnectedAccount;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class UserStripeAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {

        $checkIfAccountExists = UserStripeConnectedAccount::where(['user_id' => auth()->id()])->first();

        if (!empty($checkIfAccountExists)) {
            throw new ModelNotFoundException('400 Bad Request', 400);
        } else {
            try {
                $createdLinkedAccount = (new Stripe)->createConnectedAccount();
                if (!empty($createdLinkedAccount->id)) {
                    $insertedData = UserStripeConnectedAccount::create([
                        'user_id' => auth()->id(),
                        'stripe_connected_account' => $createdLinkedAccount->id,
                        'is_completed' => false,
                        'is_active' => true
                    ]);

                    if (!empty($insertedData->id)) {
                        return back()->with('success', 'Account created, please provide more details to active');
                    } else {
                        return back()->with('fail', 'Something went wrong, try again');
                    }
                }
            } catch (Exception $e) {
                return back()->with('fail', 'Something went wrong, try again');
            }
        }
    }

    public function syncAc(UserStripeConnectedAccount $userStripeConnectedAccount)
    {

        if (!empty($userStripeConnectedAccount->id) && !empty($userStripeConnectedAccount->stripe_connected_account)) {
            
            try {
                $connectedAcDetails = (new Stripe())->viewConnectedAccount($userStripeConnectedAccount->stripe_connected_account);
                
;            if (!empty($connectedAcDetails['data']['capabilities']['transfers']) && ($connectedAcDetails['data']['capabilities']['transfers'] == 'active') && (!empty($connectedAcDetails['data']['capabilities']['card_payments'])) && (($connectedAcDetails['data']['capabilities']['card_payments']) == 'active') &&(!empty($connectedAcDetails['data']['charges_enabled'])) && ($connectedAcDetails['data']['charges_enabled'] == true)) {
                
                $userStripeConnectedAccount->is_completed = true;
                $userStripeConnectedAccount->save();
            } 

            $res = [
                'key' => 'success',
                'msg' => 'Synced sucessfuly',
                'data' => $userStripeConnectedAccount
            ];

            } catch (Exception $e) {
                $res = [
                    'key' => 'fail',
                    'msg' => $e->getMessage() ?? 'Something went wrong'
                ];
            }

            return $res;

        }
    }

    public function update(UserStripeConnectedAccount $userStripeConnectedAccount, Request $request)
    {
        $res = [
            'key' => 'fail',
            'msg' => 'Something went wrong'
        ];

        try {
            $this->validate($request, [
                'email' => ['email', 'required'],
                'companyCountry' => ['required'],
                'companyState' => ['required'],
                'companyCity' => ['required'],
                'companyPostalCode' => ['required', 'numeric', 'digits:5'],
                'companyAddrLine1' => ['required'],
                'companyAddrLine2' => ['required'],
                'businessProfileName' => ['required'],
                'businessProfileDesc' => ['required'],
                'acHolderDOB' => ['required', 'date', 'date_format:m/d/Y'],
                'acHolderState' => ['required'],
                'acHolderCity' => ['required'],
                'acAddrLine1' => ['required'],
                'acAddrPostalCode' => ['required', 'numeric', 'digits:5'],
                'acHolderSSN' => ['required', 'numeric', 'digits:4'],
                'acHolderBankAC' => ['required', 'numeric'],
                'acHolderCurrency' => ['required'],
                'acHolderRouting' => ['required', 'numeric']

            ]);

            if (!empty($userStripeConnectedAccount)) {

                $userStripeId = $userStripeConnectedAccount->stripe_connected_account;
                $payLoad = $this->preparePayloadForConnectedAcUpdate($request, $userStripeId);

                $updatedAcDetailsInStripe = (new Stripe())->updateConnectedAccount($payLoad);

                if (!empty($updatedAcDetailsInStripe['code']) && ($updatedAcDetailsInStripe['code'] == 200)) {

                    $localizedUpdate = $this->updateStripeAcDetailsLocally($userStripeConnectedAccount, $payLoad);

                    $connectedAcDetails = (new Stripe())->viewConnectedAccount($userStripeId);

                    if (!empty($connectedAcDetails['code']) && ($connectedAcDetails['code'] == 200) && (!empty($connectedAcDetails['data']))) {

                        if (!empty($userStripeConnectedAccount->is_completed)) {
                            $res = [
                                'key' => 'success',
                                'msg' => 'Your payment account details has been submitted successfully. Please check back in some time'
                            ];
                        } else {
                            $res = [
                                'key' => 'success',
                                'msg' => 'Your payment account details has been updated successfully.'
                            ];
                        }
                    } else {
                        $res = [
                            'key' => 'fail',
                            'msg' => 'Your payment account has not been activated yet. Please provide all the details'
                        ];
                    }
                } else {

                    $res = [
                        'key' => 'fail',
                        'msg' => $updatedAcDetailsInStripe['data'] ?? 'Something went wrong'
                    ];
                }
            }
        } catch (Exception $e) {

            $res = [
                'key' => 'fail',
                'msg' => $e->getMessage() ?? 'Something went wrong'
            ];
        }

        return $res;
    }


    private function updateStripeAcDetailsLocally($userStripeConnectedAccount, $payLoad)
    {

        if (!empty($userStripeConnectedAccount) && !empty($payLoad)) {
            try {

                $userStripeConnectedAccount->email = $payLoad['email'] ?? null;
                $userStripeConnectedAccount->company_country = $payLoad['companyCountry'] ?? null;
                $userStripeConnectedAccount->company_state = $payLoad['companyState'] ?? null;
                $userStripeConnectedAccount->company_city = $payLoad['companyCity'] ?? null;
                $userStripeConnectedAccount->company_postal_code = $payLoad['companyPostalCode'] ?? null;
                $userStripeConnectedAccount->company_addr_line_1 = $payLoad['companyAddrLine1'] ?? null;
                $userStripeConnectedAccount->company_addr_line_2 = $payLoad['companyAddrLine2'] ?? null;
                $userStripeConnectedAccount->business_profile_name = $payLoad['businessProfileName'] ?? null;
                $userStripeConnectedAccount->business_profile_desc = $payLoad['businessProfileDesc'] ?? null;
                $userStripeConnectedAccount->ac_holder_dob = $payLoad['acHolderDOB'] ?? null;
                $userStripeConnectedAccount->ac_holder_state = $payLoad['acHolderState'] ?? null;
                $userStripeConnectedAccount->ac_holder_city = $payLoad['acHolderCity'] ?? null;
                $userStripeConnectedAccount->ac_addr_line_1 = $payLoad['acAddrLine1'] ?? null;
                $userStripeConnectedAccount->ac_addr_postal_code = $payLoad['acAddrPostalCode'] ?? null;
                $userStripeConnectedAccount->ac_holder_ssn = $payLoad['acHolderSSN'] ?? null;
                $userStripeConnectedAccount->ac_holder_bank_ac = $payLoad['acHolderBankAC'] ?? null;
                $userStripeConnectedAccount->currency = $payLoad['acHolderCurrency'] ?? null;
                $userStripeConnectedAccount->ac_holder_routing = $payLoad['acHolderRouting'] ?? null;

                $userStripeConnectedAccount->save();
            } catch (\Throwable $th) {
                dd($th);
            }
        }
    }

    private function preparePayloadForConnectedAcUpdate($data, $id)
    {
        return [
            'stripeConnectedAcId' => $id ?? '',
            'email' => $data->email ?? '',
            'companyCountry' => $data->companyCountry ?? '',
            'companyState' => $data->companyState ?? '',
            'companyCity' => $data->companyCity ?? '',
            'companyPostalCode' => $data->companyPostalCode ?? '',
            'companyAddrLine1' => $data->companyAddrLine1 ?? '',
            'companyAddrLine2' => $data->companyAddrLine2 ?? '',
            'businessProfileName' => $data->businessProfileName ?? '',
            'businessProfileDesc' => $data->businessProfileDesc ?? '',
            'acHolderDOB' => $data->acHolderDOB ?? '',
            'dobDay' => !empty($data->acHolderDOB) ? Carbon::createFromFormat('m/d/Y', $data->acHolderDOB)->format('d') : '',
            'dobMonth' => !empty($data->acHolderDOB) ? Carbon::createFromFormat('m/d/Y', $data->acHolderDOB)->format('m') : '',
            'dobYear' => !empty($data->acHolderDOB) ? Carbon::createFromFormat('m/d/Y', $data->acHolderDOB)->format('Y') : '',
            'acHolderState' => $data->acHolderState ?? '',
            'acHolderCity' => $data->acHolderCity ?? '',
            'acAddrLine1' => $data->acAddrLine1,
            'acAddrPostalCode' => $data->acAddrPostalCode ?? '',
            'acHolderSSN' => $data->acHolderSSN,
            'acHolderBankAC' => $data->acHolderBankAC ?? '',
            'acHolderCurrency' => $data->acHolderCurrency ?? '',
            'acHolderRouting' => $data->acHolderRouting ?? ''
        ];
    }
}
