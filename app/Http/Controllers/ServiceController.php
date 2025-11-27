<?php
namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('name','description','price','category');

        if($request->hasFile('img')){
            $data['img'] = $request->file('img')->store('services','public');
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success','Service added successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('name','description','price','category');

        if($request->hasFile('img')){
            if($service->img){
                Storage::disk('public')->delete($service->img);
            }
            $data['img'] = $request->file('img')->store('services','public');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success','Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if($service->img){
            Storage::disk('public')->delete($service->img);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success','Service deleted successfully.');
    }
}