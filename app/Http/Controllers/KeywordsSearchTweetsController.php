<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KeywordsSearchTweets;
use App\Http\Requests\StoreKeywordsSearchTweets;

class KeywordsSearchTweetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keywords_search_tweets = KeywordsSearchTweets::all();
        return view('keywords_search_tweets.index', compact('keywords_search_tweets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keywords_search_tweets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKeywordsSearchTweets $request)
    {
        KeywordsSearchTweets::create($request->all());
        return redirect()->route('keywords_search_tweets.index')->with('success', '新規登録完了しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $keywords_search_tweets = KeywordsSearchTweets::find($id);
        return view('keywords_search_tweets.show', compact('keywords_search_tweets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $keywords_search_tweets = KeywordsSearchTweets::find($id);
        return view('keywords_search_tweets.edit', compact('keywords_search_tweets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreKeywordsSearchTweets $request, $id)
    {
        $update = [
            'keyword' => $request->keyword,
            //'executed_at' => $request->executed_at
        ];
        KeywordsSearchTweets::where('id', $id)->update($update);
        return back()->with('success', '編集完了しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KeywordsSearchTweets::where('id', $id)->delete();
        return redirect()->route('keywords_search_tweets.index')->with('success', '削除完了しました');
    }
}
