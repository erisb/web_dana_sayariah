<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except'=>['getNews','getDetil']]);
    }
    
    public function getNews() {
        $news = News::orderBy('updated_at', 'desc')->get();

        $x=0;
        if (!isset($news[0])) {
            $newest = null;
        }
        else {
            foreach ($news as $item){
                $newest[$x] = [
                    'id'=>$item->id,
                    'title'=>$item->title,
                    'image'=>'/storage/'.$item->image,
                    'writer'=>$item->writer,
                    'updated_at'=>$item->updated_at->toDateString(),
                ];
                $x++;
            }
        }
        

        return [
            'news' => $newest,
        ];
    }

    public function getDetil(Request $request){
        $detils = News::where('id', $request->id_news)->first();

        return [
            'id'=>$detils->id,
            'title'=>$detils->title,
            'image'=>'/storage/'.$detils->image,
            'writer'=>$detils->writer,
            'deskripsi'=>$detils->deskripsi,
            'updated_at'=>$detils->updated_at->toDateString(),
        ];
    }
}
