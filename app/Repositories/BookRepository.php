<?php

namespace App\Repositories;
use App\Models\Book;
use App\Interfaces\BookRepositoryInterface;
use Illuminate\Http\Request;
class BookRepository implements BookRepositoryInterface
{
    public function index(Request $request){
        $query = Book::query();
        if($request->has('keyword'))
        {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
            $query->orWhere('author', 'LIKE', '%' . $request->keyword . '%');
        }
        if($request->has('limit'))
        {
            return $query->paginate($request->limit);
        }
        return $query->get();
    }

    public function getById($id){
        return Book::findOrFail($id);
    }

    public function store(array $data){
        return Book::create($data);
    }

    public function update(array $data,$id){
        return Book::whereId($id)->update($data);
    }

    public function delete($id){
        Book::destroy($id);
    }
}
