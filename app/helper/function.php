<?php
use Illuminate\Support\Facades\DB;
function name(){
    return DB::table('product')->get();
}
function oneRow($id,$table){
    return DB::table($table)->where('id',$id)->get();
}
function oneField($id,$field,$table){
    return DB::table($table)->select($field)->where('id',$id)->get();
}
?>