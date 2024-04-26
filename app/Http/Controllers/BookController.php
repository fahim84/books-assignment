<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Interfaces\BookRepositoryInterface;
use App\Classes\ResponseClass;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\DB;
class BookController extends Controller
{
    private BookRepositoryInterface $bookRepositoryInterface;

    public function __construct(BookRepositoryInterface $bookRepositoryInterface)
    {
        $this->bookRepositoryInterface = $bookRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->bookRepositoryInterface->index();

        return ResponseClass::sendResponse(BookResource::collection($data),'',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $details =[
            'name' => $request->name,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try{
            $book = $this->bookRepositoryInterface->store($details);

            DB::commit();
            return ResponseClass::sendResponse(new BookResource($book),'Book Create Successful',201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = $this->bookRepositoryInterface->getById($id);

        return ResponseClass::sendResponse(new BookResource($book),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $updateDetails =[
            'name' => $request->name,
            'details' => $request->details
        ];
        DB::beginTransaction();
        try{
            $book = $this->bookRepositoryInterface->update($updateDetails,$id);

            DB::commit();
            return ResponseClass::sendResponse('Book Update Successful','',201);

        }catch(\Exception $ex){
            return ResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->bookRepositoryInterface->delete($id);

        return ResponseClass::sendResponse('Book Delete Successful','',204);
    }
}
