<?php

namespace App\Http\Controllers;

use App\Helper\Media;
use App\Models\Cart;
use App\Models\Club;
use App\Models\ClubAddress;
use App\Models\ClubImage;
use App\Models\ClubList;
use App\Models\User;
use App\Models\WishList;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

use Jorenvh\Share\ShareFacade;

class ProductController extends Controller
{
    use Media;

    public function index()
    {

        $products =  Club::with(['clubLists'])->where([
            'user_id' => auth()->id(),

        ])->get();


        return $products;
    }

    public function view(Club $club,Request $request)
    {
        
        $club = $club::with([
            'clubLists', 'clubAddresses', 'user', 'clubRatings' =>
            function ($q) {
                $q->orderBy('created_at', 'DESC');
            }, 'clubRatings.user', 'user.userStripeConnectedAccount' =>
            function ($q) {
                $q->where('is_completed', true);
                $q->where('is_active', true);
            }
        ])->where(['is_active' => true])->find($club->id);
        $clubReviews = $club->clubRatings();

        if($request->has('sortBy')){
            
            switch ($request->sortBy) {
                case 'MOST_RECENT':
                    $clubReviews->orderBy('created_at', 'DESC');
                    break;
                case 'POSITIVE_FIRST':
                    $clubReviews->orderBy('rating', 'DESC');
                    break;
                case 'NEGATIVE_FIRST':
                    
                    $clubReviews->orderBy('rating', 'ASC');
                    break;
                    
                default:
                $clubReviews->orderBy('created_at', 'DESC');
                    break;
            }
            
        }
        else
        {
            $clubReviews->orderBy('created_at', 'DESC');
        }

        $clubReviews= $clubReviews->with(['clubRatingReplies','clubRatingReplies.user'=>function($q){
            $q->orderBy('created_at','DESC');
        }])->paginate(3);
    
        

        if (!empty($club) && !empty($club->user->userStripeConnectedAccount->is_completed) && !empty($club->user->userStripeConnectedAccount->is_active)) {
            $ifPresentInCart = $ifPresentInWishList = false;
            if (auth()->id()) {
                $ifPresentInWishList = WishList::where([
                    'user_id' => auth()->id(),
                    'club_id' => $club->id
                ])->first();

                $ifPresentInCart = Cart::with(['cartItems' => function ($q) use ($club) {
                    $q->where('club_id', $club->id);
                }])->where(['user_id' => auth()->id()])->first();
            } else {
                $allCookies = Cookie::get();

                if (!empty($allCookies['auth_key'])) {
                    $ifPresentInWishList = WishList::where([
                        'guest_id' => $allCookies['auth_key'],
                        'club_id' => $club->id
                    ])->first();


                    $ifPresentInCart = Cart::with(['cartItems' => function ($q) use ($club) {
                        $q->where('club_id', $club->id);
                    }])->where(['guest_id' => $allCookies['auth_key']])->first();
                }
            }

            return view(
                'product.show.index',
                [
                    'club' => $club,
                    'isWishListed' => !empty($ifPresentInWishList->id) ? true : false,
                    'isInCart' => (!empty($ifPresentInCart->cartItems) && count($ifPresentInCart->cartItems) > 0)  ? true : false,
                    'clubReviews' => $clubReviews
                ]
            );
        } else {
            throw new ModelNotFoundException();
        }
    }
    public function getCreateClubView()
    {

        $this->authorize('create', 'App\Club');

        return view('product.create.index');
    }

    public function create(Request $request)
    {

        $this->authorize('create', 'App\Club');

        $errorBags = $this->validateProductInsertion($request);

        if (!empty($errorBags)) {
            throw ValidationException::withMessages($errorBags);
        }

        $payload = json_decode($request->payload);

        $listType = $payload->listType ?? null;
        $isMix = $payload->isMix == 'true' ? true : false;
        $addresses = !empty($payload->addresses) ?  $payload->addresses : null;


        try {

            $res = [
                'key' => 'success',
                'msg' => 'You club has been listed successfully and pending for approval!'
            ];

            $createdClub = $this->createClub($payload);

            if (!empty($createdClub->id)) {


                $this->createClubList($payload, $request, $createdClub, ($listType == 'set' ? true : false));
                $this->createClubAddress($addresses, $createdClub);
            } else {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Clubs can not be listed'
                ];
            }

            if ($isMix) {
                $products = $payload->products ?? null;
                $clubs = $payload->clubs ?? null;
                if (!empty($products)) {
                    $payload->setName = null;
                    $payload->setProductPriceUnit = null;
                    $payload->setProductPrice = null;
                    $payload->listType = 'individual';

                    foreach ($products as $key => $eachProd) {
                        $payload->products = [$eachProd];
                        $payload->clubs = !empty($clubs[$key]) ? [$clubs[$key]] : null;

                        $createdClub = $this->createClub($payload);
                        $this->createClubList($payload, $request, $createdClub);
                        $this->createClubAddress($addresses, $createdClub);
                    }
                }
            }
        } catch (Exception $e) {

            $res = [
                'key' => 'fail',
                'msg' => 'Something went wrong. Try again later'
            ];
        }

        return $res;
    }


    public function clubPrice(Club $club)
    {
        if (!empty($club->type) && ($club->type == 'set')) {
            return [
                'price' => $club->set_price ?? null,
                'unit' => $club->set_price_unit ?? null
            ];
        } elseif (!empty($club->type) && ($club->type == 'individual')) {
            return [
                'price' => $club->clubLists[0]->price ?? null,
                'unit' => $club->clubLists[0]->priceUnit ?? null
            ];
        }
    }

    private function validateProductInsertion(Request $request)
    {
        $payload = json_decode($request->payload);

        $listType = $payload->listType ?? null;
        $isMix = $payload->isMix == 'true' ? true : false;
        $clubs = $payload->clubs ?? null;
        $gender = $payload->gender ?? null;
        $priorTime = $payload->priorTime ?? null;
        $dexterity = $payload->dexterity ?? null;
        $addresses = !empty($payload->addresses) ?  $payload->addresses : null;
        $setName = $payload->setName ?? null;
        $setProductPriceUnit = $payload->setProductPriceUnit ?? null;
        $setProductPrice = $payload->setProductPriceUnit ?? null;
        $products = $payload->products ?? null;

        $prodImages = [];
        $allowedImgArr = [
            'jpeg',
            'jpg',
            'gif',
            'png',
            'bmp',
            'webp',
            'avif'
        ];
        $isValidated = false;
        //    throw ValidationException::withMessages(['test msg']);
        $errorBags = [];
        if (empty($listType) || !in_array($listType, ['individual', 'set'])) {
            array_push($errorBags, ['Please select list type']);
        }

        if (empty($clubs) || !is_array($clubs) || (count($clubs) < 0)) {
            array_push($errorBags, ['Please select atleast one club']);
        }
        if (empty($gender)) {
            array_push($errorBags, ['Please select gender']);
        }
        if (empty($dexterity)) {
            array_push($errorBags, ['Please select dexterity']);
        }
        // if(empty($priorTime))
        // {
        //     array_push($errorBags,['Please select time required prior to rental']);
        // }
        if (empty($addresses) || !is_array($addresses) || (count($addresses) < 0)) {
            array_push($errorBags, ['Please select at least one pickup/drop off location']);
        }
        if (empty($products) || !is_array($products) || count($products) < 0) {
            array_push($errorBags, ['Please select at least one ']);
        } else {
            foreach ($products as $key => $val) {
                if ($listType == 'individual' || $isMix) {
                    if (empty($val->productPriceUnit)) {
                        array_push($errorBags, ['Please provide price unit for ' . $clubs[$key] ?? 'no' . $key . ' product']);
                    }
                    if (empty($val->productPrice) || !is_numeric(intval($val->productPrice))) {
                        array_push($errorBags, ['Please provide price for ' . $clubs[$key] ?? 'no' . $key . ' product']);
                    }
                }
                if (empty($val->brand) || (Str::length($val->brand) > 255)) {
                    array_push($errorBags, ['Please select valid brand name for ' . $clubs[$key] ?? ' no ' . $key . ' product']);
                }
                if (empty($val->length) || !is_numeric(intval($val->length))) {
                    array_push($errorBags, ['Please provide valid length for ' . $clubs[$key] ?? ' no ' . $key . ' product']);
                }
                if (empty($val->flex) || (Str::length($val->flex) > 255)) {
                    array_push($errorBags, ['Please select flex for ' . $clubs[$key] ?? ' no ' . $key . ' product']);
                }
                if (empty($val->loft) || !is_numeric(intval($val->loft))) {
                    array_push($errorBags, ['Please provide valid loft for ' . $clubs[$key] ?? ' no ' . $key . ' product']);
                }
                if (empty($val->prodImg) || !is_array($val->prodImg) || count($val->prodImg) < 0) {
                    array_push($errorBags, ['Please provide image for ' . $clubs[$key] ?? ' no ' . $key . ' product']);
                }
                if (!empty($val->prodImg) || count($val->prodImg) > 0) {
                    foreach ($val->prodImg as $eachImg) {
                        if (!empty($request->file($eachImg)) && ($request->file($eachImg) instanceof UploadedFile)) {
                            $extension = $request->file($eachImg)->getClientOriginalExtension();
                            if (!in_array($extension, $allowedImgArr)) {
                                array_push($errorBags, [(!empty($clubs[$key]) ? $clubs[$key] : ' no ' . $key . 'product') . ' image must be a type of jpg/jpeg/gif/bmp/webp']);
                            } elseif ($request->file($eachImg)->getFileInfo()->getSize() > 5048576) {
                                array_push($errorBags, [(!empty($clubs[$key]) ? $clubs[$key] : ' no ' . $key . 'product') . ' image should not be more than 5MB']);
                            }
                        } else {
                            array_push($errorBags, ['Please provide a valid image for ' . (!empty($clubs[$key]) ? $clubs[$key] : ' no ' . $key . 'product')]);
                        }
                        //    array_push($prodImages,$request->file($eachImg));
                    }
                }
                if (!empty($val->addOnImg) && count($val->addOnImg) > 0) {
                    foreach ($val->addOnImg as $eachAddOnImg) {
                        if (!empty($request->file($eachAddOnImg)) && ($request->file($eachAddOnImg) instanceof UploadedFile)) {
                            $extension = $request->file($eachAddOnImg)->getClientOriginalExtension();
                            if (!in_array($extension, $allowedImgArr)) {
                                array_push($errorBags, [(!empty($clubs[$key]) ? $clubs[$key] : ' no ' . $key . 'product') . ' image must be a type of jpg/jpeg/gif/bmp/webp']);
                            } elseif ($request->file($eachAddOnImg)->getFileInfo()->getSize() > 5048576) {
                                array_push($errorBags, [(!empty($clubs[$key]) ? $clubs[$key] : ' no ' . $key . 'product') . ' image should not be more than 5MB']);
                            }
                        } else {
                            array_push($errorBags, ['Please provide valid image for ' . (!empty($clubs[$key]) ? $clubs[$key] : ' no ' . $key . ' product')]);
                        }
                    }
                }
            }
        }

        if ($listType == 'set') {
            if (empty($setName) || (Str::length($val->flex) > 255)) {
                array_push($errorBags, ['Please provide valid set name']);
            }
            if (empty($setProductPriceUnit)) {
                array_push($errorBags, ['Please provide price unit for the club set']);
            }
            if (empty($setProductPrice) || !is_numeric(intval($setProductPrice))) {
                array_push($errorBags, ['Please provide price for the club set']);
            }
        }



        return $errorBags;
    }

    private function createClub($payload)
    {
        $listType = $payload->listType ?? null;
        // $clubs = $payload->clubs ?? null;
        $gender = $payload->gender ?? null;
        $dexterity = $payload->dexterity ?? null;
        $priorTime = $payload->priorTime ?? null;
        // $addresses = !empty($payload->addresses) ?  $payload->addresses : null;
        $setName = $payload->setName ?? null;
        $setProductPriceUnit = $payload->setProductPriceUnit ?? null;
        $setProductPrice = $payload->setProductPrice ?? null;
        // $products = $payload->products ?? null;

        $createdClub = Club::create([
            'set_name' => $setName,
            'slug' => Str::uuid(),
            'type' => $listType,
            'gender' => $gender,
            'dexterity' => $dexterity,
            'adv_time' => $priorTime,
            'set_price' => floatval($setProductPrice),
            'set_price_unit' => strtolower($setProductPriceUnit),
            'user_id' => auth()->id(),
            'is_active' => false
        ]);

        return $createdClub;
    }

    private function createClubList($payload, $request, $club, $isSet = false)
    {
        $products = $payload->products ?? null;
        $clubs = $payload->clubs ?? null;
        foreach ($products as $key => $eachProd) {
            $thisCreatedClubList = ClubList::create([
                'club_id' => $club->id,
                'name' => $clubs[$key] ?? '',
                'slug' => Str::uuid(),
                'price' => !empty($eachProd->productPrice) ? floatval($eachProd->productPrice) : null,
                'priceUnit' => $eachProd->productPriceUnit ?? null,
                'brand' => $eachProd->brand,
                'length' => $eachProd->length,
                'loft' => $eachProd->loft,
                'flex' => $eachProd->flex,
                'is_adjustable' => $eachProd->is_adjustable,
                'is_set' => $isSet,

            ]);

            if (!empty($thisCreatedClubList->id)) {

                foreach ($eachProd->prodImg as $eachImg) {

                    if (!empty($request->$eachImg)) {
                        $fileData = $this->uploads($request->$eachImg, 'clubs/images' . str_replace(' ', '_', $clubs[$key]) . '_' . Str::uuid());

                        $thisImageData = ClubImage::create([
                            'club_list_id' => $thisCreatedClubList->id,
                            'image_path' => $fileData['filePath'] ?? null
                        ]);
                    }
                }
            }
        }
    }

    public function createClubAddress($addresses, $club)
    {
        foreach ($addresses as $eachAddress) {
            $eachAddress = json_decode($eachAddress);
            $thisAddress = ClubAddress::create([
                'club_id' => $club->id,
                'loc_name' => $eachAddress->name ?? null,
                'price' => $eachAddress->price ?? null,
                'price_unit' => $eachAddress->priceUnit ?? null,
                'address' => $eachAddress->address ?? null,
                'lat' => ($eachAddress->lat) ?? null,
                'lng' => ($eachAddress->lng) ?? null,
                'locType' => $eachAddress->locType ?? null
            ]);
        }
    }
}
