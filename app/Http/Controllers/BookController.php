<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Interfaces\BookRepositoryInterface;
use App\Classes\ApiResponseClass;
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

        return ApiResponseClass::sendResponse(BookResource::collection($data),'',200);
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
            'title' => $request->title,
            'author' => $request->author,
            'publication_year' => $request->publication_year,
            'isbn' => $request->isbn

        ];
        DB::beginTransaction();
        try{
            $book = $this->bookRepositoryInterface->store($details);

            DB::commit();
            return ApiResponseClass::sendResponse(new BookResource($book),'Book Create Successful',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if(Book::find($id))
        {
            $book = $this->bookRepositoryInterface->getById($id);

            return ApiResponseClass::sendResponse(new BookResource($book),'',200);
        }
        else
        {
            return ApiResponseClass::sendResponse(null,'Record not found',404);
        }
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
        if(Book::find($id))
        {
            $updateDetails =[
                'title' => $request->title,
                'author' => $request->author,
                'publication_year' => $request->publication_year,
                'isbn' => $request->isbn
            ];
            DB::beginTransaction();
            try{
                $book = $this->bookRepositoryInterface->update($updateDetails,$id);

                DB::commit();
                return ApiResponseClass::sendResponse('Book Update Successful','',201);

            }catch(\Exception $ex){
                return ApiResponseClass::rollback($ex);
            }
        }
        else
        {
            return ApiResponseClass::sendResponse(null,'Record not found',404);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(Book::find($id))
        {
            $this->bookRepositoryInterface->delete($id);

            return ApiResponseClass::sendResponse('Book Delete Successful','',204);
        }
        else
        {
            return ApiResponseClass::sendResponse(null,'Record not found',404);
        }
    }
}
