<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   function __construct()
   {
      $this->middleware('auth:administrator');
   }

   public function index()
   {
      $clubs = Club::with(['clubLists', 'clubAddresses', 'user'])->get();

      return view('administrator.product.view.index', ['clubs' => $clubs]);
   }

   public function approve(Club $club)
   {


      if (!empty($club)) {
         try {
            $club->is_active = true;
            $isApproved = $club->save();
            if (!empty($isApproved)) {
               $res = [
                  'key' => 'success',
                  'msg' => 'Club has been approved successfully'
               ];
            } else {
               $res = [
                  'key' => 'fail',
                  'msg' => 'Club has been not approved'
               ];
            }
         } catch (Exception $e) {
            $res = [
               'key' => 'fail',
               'msg' => 'Something went wrong'
            ];
         }
      } else {
         $res = [
            'key' => 'fail',
            'msg' => 'Club has been not approved'
         ];
      }

      return $res;
   }

   public function suspend(Club $club)
   {
      if (!empty($club)) {
         try {
            $club->is_active = false;
            $isApproved = $club->save();
            if (!empty($isApproved)) {
               $res = [
                  'key' => 'success',
                  'msg' => 'Club has been suspended successfully'
               ];
            } else {
               $res = [
                  'key' => 'fail',
                  'msg' => 'Club has been not suspended'
               ];
            }
         } catch (Exception $e) {
            $res = [
               'key' => 'fail',
               'msg' => 'Something went wrong'
            ];
         }
      } else {
         $res = [
            'key' => 'fail',
            'msg' => 'Club has been not suspended'
         ];
      }

      return $res;
   }
}
