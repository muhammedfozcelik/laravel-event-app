<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events=Event::with(['category','user'])->orderBy('event_date','asc')->get();
        $categories=Category::all();
        return view('events.index',compact('events','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function listByCategory($slug)
    {
        $category=Category::where('slug',$slug)->firstorFail();
        $events=$category->events()->with(['user'])->orderBy('event_date','asc')->get();
        $categories=Category::all();
        return view('events.index',compact('events','categories','category'));
    }
    public function create()
    {
        $categories=Category::all();
        return view('events.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'event_date'=>'required|date|after:now',
            'category_id'=>'required|exists:categories,id',
        ]);
        Event::create([
            ...$request->all(),
            'user_id'=>Auth::id(),
        ]);

        return redirect()->route('events.index')->with('success', 'Etkinlik oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        if($event->user_id !== Auth::id()){
            return redirect()->route('events.index')->with('error','Bu etkinliği düzenleme yetkiniz yok.');
        }
        $categories=Category::all();
        return view('events.edit',compact('event','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        if($event->user_id !== Auth::id()){
            return redirect()->route('events.index')->with('error','Bu etkinliği düzenleme yetkiniz yok.');
        }
        $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'event_date'=>'required|date|after:now',
            'category_id'=>'required|exists:categories,id',
        ]);
        $event->update($request->all());
        return redirect()->route('events.show',$event->id)->with('success','Etkinlik güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if($event->user_id !== Auth::id()){
            return redirect()->route('events.index')->with('error','Bu etkinliği silme yetkiniz yok.');
        }
        $event->delete();
        return redirect()->route('events.index')->with('success','Etkinlik silindi.');
    }
}
