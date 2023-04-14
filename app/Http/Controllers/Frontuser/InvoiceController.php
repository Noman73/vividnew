<?php

namespace App\Http\Controllers\Frontuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Fuser;
use App\Models\DCommision;
use App\Models\Product;
use Validator;
use Redirect;
use DataTables;
use DB;
use App\Http\Traits\WalletBalanceTrait;
class InvoiceController extends Controller
{
    use WalletBalanceTrait;
    public function __construct(){
        $this->middleware('auth:fuser');
    }
    public function Form(){
        $product=Product::all();
        return view('frontend.invoices.invoice',compact('product'));
    }
    public function Create(Request $r){
        // return $r->all();
        $total=0;
        for ($i=0; $i <count($r->product) ; $i++) { 
            $query=Product::where('id',$r->product[$i])->first();
            $total+=floatval($r->qantity[$i])*floatval($query->sales_rate);
        }
        // return $this->WalletBalance();
        if($this->WalletBalance()<$total){
            return response()->json(['error'=>'Wallet Balance Is Low than Your 
            Purchase Ammount']);
        }
        $validator = Validator::make($r->all(),[
            'fuser' => 'required|regex:/^([0-9]+)$/',
            'product' => 'required|array',
            'product.*' => 'required|distinct|regex:/^([0-9]+)$/',
            'qantity' => 'required|array',
            'qantity.*' => 'required|regex:/^([0-9]+)$/',
        ]);

        if ($validator->passes()) {
            $ref_vp=Invoice::where('fuser_id',$r->fuser)->sum('vp');
            $total_vp=0;
            for ($i=0; $i < count($r->product); $i++) {
                $query=Product::where('id',$r->product[$i])->first();
                $invoice = new Invoice;
                $invoice->owner_id = auth()->user()->id;
                $invoice->fuser_id = $r->fuser;
                $invoice->product_id = $query->id;
                $invoice->price = $query->sales_rate;
                $invoice->qantity = $r->qantity[$i];
                $invoice->vp = $query->vp*$r->qantity[$i];
                $invoice->dates = time();
                $invoice->save();
                $total_vp+=floatval($query->vp*$r->qantity[$i]);
            }
            $ref_id=Fuser::where('id',$r->fuser)->first()->reffer_id;
            $percent=$this->getPercentagForReff($ref_id);
            if($invoice){
                $commision=new DCommision;
                $commision->ammount=(($total_vp*48)*$percent)/100;
                if($ref_vp>=180){
                    $commision->user_id=$r->fuser;
                }else{
                    $commision->user_id=$ref_id;
                }
                $commision->date=strtotime(date("d-m-Y 00:00:00"));
                $commision->author_id=auth()->user()->id;
                $commision->save();   
            }
            return response()->json(['message'=>'Product Purchase Success']);
        }
        if($validator->fails()){
            return response()->json($validator->getMessageBag());
        }
    }
    public function InvoiceList(){
        if(request()->ajax()){
            $get = DB::select("
          SELECT invoices.price,invoices.qantity,products.name,invoices.vp FROM invoices 
          inner join products on products.id=invoices.product_id 
          where invoices.fuser_id= :fuser_id",['fuser_id'=>auth()->user()->id]);
            return DataTables::of($get)
                ->addIndexColumn()
                ->addColumn('total', function($get){
                    return (floatval($get->qantity)*floatval($get->price));
                })
                ->rawColumns(['total'])->make(true);
        }
        return view('frontend.invoices.invoice_list');
    }

    public function getPercentagForReff($fuser_id)
    {
        $total_vp=Invoice::where('fuser_id',$fuser_id)->sum('vp');
        switch ($total_vp) {
            case $total_vp<10:
                return 0;
                break;
            case $total_vp<60:
                return 10;
                break;
            case $total_vp<125:
                return 15;
                break;
            case $total_vp>=125:
                return 20;
                break;
            default:
                return 0;
                break;
        }
    }
}
