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
        // $cacheKey = 'topics-index-user-' .  auth()->id();
        // $topics = cache()->remember($cacheKey, 60, function () {
        //     return Topic::with('user')->get()->map(function ($topic) {
        //         return [
        //             'id' => $topic->id,
        //             'name' => $topic->name,
        //             'image' => asset('storage/' . $topic->image),
        //             'user' => [
        //                 'id' => $topic->user->id,
        //                 'name' => $topic->user->name
        //             ]
        //         ];
        //     });
        // });

        $topics = Topic::with('user')->paginate()->map(function ($topic) {
            return [
                'id' => $topic->id,
                'name' => $topic->name,
                'image' => asset('storage/' . $topic->image),
                'user' => [
                    'id' => $topic->user->id,
                    'name' => $topic->user->name
                ]
            ];
        });

        return inertia('Topics/IndexTopics', compact('topics'));
    }

    public function create()
    {
        $this->authorize('create', Topic::class);
        return Inertia::render('Topics/CreateTopic');
    }

    public function store(StoreTopicRequest $request)
    {
        $this->authorize('create', Topic::class);

        $image = $request->file('image')->store('topics', 'public');

        Topic::create([
            'name' => $request->input('name'),
            'image' => $image,
        ]);


        return Redirect::route('topics.index')
            ->with('message', 'Topic created successfully!');
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);

        return Inertia::render('Topics/EditTopic', [
            'topic' => $topic,
            'image' => asset('storage/' . $topic->image)
        ]);
    }

    public function update(Topic $topic, UpdateTopicRequest $request)
    {
        $this->authorize('update', $topic);

        $image = $topic->image;
        if ($request->file('image')) {
            Storage::delete('public/' . $image);
            $image = $request->file('image')->store('topics', 'public');
        }

        $topic->update([
            'name' => $request->input('name'),
            'image' => $image
        ]);

        return Redirect::route('topics.index')->with('message', 'Topic updated successfully!');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('delete', $topic);

        Storage::delete('public/' . $topic->image);
        $topic->delete();

        return Redirect::route('topics.index')->with('message', 'Topic deleted successfully!');;
    }
}
