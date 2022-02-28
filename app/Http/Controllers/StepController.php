<?php

namespace App\Http\Controllers;

use App\Http\Requests\StepModifyRequest;
use App\Http\Requests\StepRequest;
use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function add(StepRequest $request)
    {
        $params = $request->validated();
        $max = Step::where('chapter_id', $request->chapter_id)->max('num');
        $params['num'] = $max+1;
        $step = new Step($params);
        $step->save();
        return back()->with('success','Step added');
    }

    public function get($id)
    {
        $steps = Step::where('chapter_id',$id)->orderBy('num','asc')->get();
        echo($steps);
    }

    public function changeNum(Request $request,$id)
    {
        $tab = json_decode($request->tab);

        for($i = 0;$i < sizeof($tab);$i++){
            Step::where('id',$tab[$i])->update(['num'=>$i+1]);
        }
        echo(json_encode("success"));

    }
    public function delete($id)
    {
        $step = Step::find($id);
        $chapter_id = $step->chapter_id;
        $step->delete();

        $steps = Step::where('chapter_id',$chapter_id)->orderBy('num','asc')->get();

        foreach ($steps as $key=>$step){
            Step::where('id',$step->id)->update(['num'=>$key+1]);
        }
        return back();
    }
    public function modify(StepModifyRequest $request,$id)
    {
        $params = $request->validated();
        $step = Step::find($id);
        $step->update([
           'title'=>$request->title,
           'content'=>$request->content
        ]);
        return back()->with('success','Changes saved !');
    }
}
