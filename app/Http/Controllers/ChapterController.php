<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterRequest;
use App\Models\Chapter;
use App\Models\Formation;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    private function getChapter($id){
        return Chapter::find($id);
    }

    public function add(ChapterRequest $request,$id)
    {
        $params = $request->validated();

        $max = Chapter::where('formation_id', $id)->max('num');
        $params['formation_id'] = $id;
        $params['num'] = $max+1;
        $chapter = new Chapter($params);
        $chapter->save();
        return back();
    }

    public function changeNum(Request $request,$id)
    {
        $tab = json_decode($request->tab);

        for($i = 0;$i < sizeof($tab);$i++){
            Chapter::where('id',$tab[$i])->update(['num'=>$i+1]);
        }

        echo(Chapter::where('formation_id',$id)->orderBy('num','asc')->get());

    }

    public function delete($id)
    {
        $chapter = Chapter::find($id);
        $formation_id = $chapter->formation_id;
        $chapter->delete();

        $chapters = Chapter::where('formation_id',$formation_id)->orderBy('num','asc')->get();

        foreach ($chapters as $key=>$chapter){
            Chapter::where('id',$chapter->id)->update(['num'=>$key+1]);
        }
        return back();
    }

    public function modify(Request $request,$id)
    {
        Chapter::where('id',$id)->update(['title'=>$request->title]);
        return back();
    }

}
