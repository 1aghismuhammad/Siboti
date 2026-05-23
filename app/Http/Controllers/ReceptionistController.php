<?php
namespace App\Http\Controllers;
class ReceptionistController extends Controller{
 public function index(){ return view('receptionist.dashboard',[
 'checkinToday'=>142,'activeMember'=>1204,'expired'=>18,'transaction'=>4200000
 ]); }
}
