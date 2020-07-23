<?php

namespace App\Http\Controllers\API;

use App\Promotion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PromotionsController extends Controller
{
    
    /**
     * @param Request $request
     * @return array|JsonResponse
     */
    public function getPromotionsList(Request $request){
        $input = $request->all();
        if(!isset($input['per_page'])){
            $per_page = '10';
        }else{
            $per_page = $input['per_page'];
        }
        if(!isset($input['current_page'])){
            $current_page = '1';
        }else{
            $current_page = $input['current_page'];
        }
        $promotions = Promotion::all();
        foreach($promotions as $promotion){
            $items[] = $promotion->toArray();
        }
        $current_items = array_slice($items, $per_page * ($current_page - 1), $per_page);
        $paginator = new LengthAwarePaginator($current_items, count($items), $per_page, $current_page);
        $pre_output['current_page'] = $paginator->currentPage();
        $pre_output['has_more_pages'] = $paginator->hasMorePages();
        $pre_output['total'] = $paginator->total();
        $pre_output['count'] = $paginator->count();
        $pre_output['promotions'] = $current_items;
        $output = [
            'success' => true,
            'response' => $pre_output,
        ];
        return response()->json($output, 200);        
    }
}
