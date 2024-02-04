<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service as ModelsService;

class ServiceController extends Controller
{

    public function index()
    {
        $services = ModelsService::paginate(10);

        return view('services.index', compact('services'));
    }

    public function ordering()
    {
        $services = ModelsService::all();

        return view('prices', compact('services'));
    }

    public function servicesCount()
    {
        $services = ModelsService::all();

        return view('layouts.dashboard', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(ServiceRequest $request)
    {
        ModelsService::create($request->validated());

        return redirect()->route('services.index')->with('success', 'Service added successfully...');
    }

    public function edit(ModelsService $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, ModelsService $service)
    {
        $service->where('id', $service->id)->update($request->validated());

        return redirect()->route('services.index')->with('success', 'Service updated successfully...');
    }

    public function destroy(ModelsService $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully...');
    }
}
