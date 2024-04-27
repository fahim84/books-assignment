<?php

namespace App\Repositories;
use App\Models\Book;
use App\Interfaces\BookRepositoryInterface;
class BookRepository implements BookRepositoryInterface
{
    public function index(){
        return Book::all();
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
