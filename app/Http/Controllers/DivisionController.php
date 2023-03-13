<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisionStoreRequest;
use App\Http\Requests\DivisionUpdateRequest;
use App\Models\Division;
use App\Repositories\DivisionRepository;

class DivisionController extends Controller
{
    public function __construct(private DivisionRepository $divisionRepository)
    {
    }

    /**
     * It returns a view called `admin.division.index` with a variable called `division` that contains
     * the result of the `get()` function in the `divisionRepository` class
     * 
     * @return The view admin.division.index and the division variable is being passed to the view.
     */
    public function index()
    {
        return view('admin.division.index', [
            'division' => $this->divisionRepository->get(),
        ]);
    }

    public function create()
    {
        return view('admin.division.create');
    }

    /**
     * It stores a new division in the database
     * 
     * @param DivisionStoreRequest request The request object.
     */
    public function store(DivisionStoreRequest $request)
    {
        $this->divisionRepository->store($request->all());

        return back()->with('success', 'You have successfully added new division.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Division $division)
    {
        return view('admin.division.edit', [
            'division' => $division,
        ]);
    }

    /**
     * It updates a division
     * 
     * @param DivisionUpdateRequest request The request object.
     * @param Division division The model that we are updating.
     * 
     * @return A view with a success message.
     */
    public function update(DivisionUpdateRequest $request, Division $division)
    {
        $this->divisionRepository->update($division, $request->all());

        return back()->with('success', 'You have successfully updated a division.');
    }

    /**
     * The function takes a division object as a parameter, and then deletes the division object from
     * the database
     * 
     * @param Division division This is the model that we are using.
     * 
     * @return A view with a success message.
     */
    public function destroy(Division $division)
    {
        $this->divisionRepository->delete($division);
        return back()->with('success', 'You have successfully deleted a division.');
    }
}
