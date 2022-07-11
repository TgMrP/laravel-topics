<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Topic;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TopicController extends Controller
{

    public function index()
    {
        return Inertia::render('Topics/IndexTopics', [
            'topics' => Topic::with('user')->get()->map(function ($topic) {
                return [
                    'id' => $topic->id,
                    'name' => $topic->name,
                    'image' => asset('storage/' . $topic->image),
                    'user' => [
                        'id' => $topic->user->id,
                        'name' => $topic->user->name
                    ]
                ];
            })
        ]);
    }

    public function create()
    {
        return Inertia::render('Topics/CreateTopic');
    }

    public function store(StoreTopicRequest $request)
    {
        $image = $request->file('image')->store('topics', 'public');
        Topic::create([
            'name' => $request->input('name'),
            'image' => $image,
        ]);


        return Redirect::route('topics.index');
    }

    public function edit(Topic $topic)
    {
        abort_if($topic->user_id !== auth()->id(), 403);

        return Inertia::render('Topics/EditTopic', [
            'topic' => $topic,
            'image' => asset('storage/' . $topic->image)
        ]);
    }

    public function update(Topic $topic, UpdateTopicRequest $request)
    {
        abort_if($topic->user_id !== auth()->id(), 403);

        $image = $topic->image;
        if ($request->file('image')) {
            Storage::delete('public/' . $image);
            $image = $request->file('image')->store('topics', 'public');
        }

        $topic->update([
            'name' => $request->input('name'),
            'image' => $image
        ]);

        return Redirect::route('topics.index');
    }

    public function destroy(Topic $topic)
    {
        abort_if($topic->user_id !== auth()->id(), 403);

        Storage::delete('public/' . $topic->image);
        $topic->delete();

        return Redirect::route('topics.index');
    }
}
