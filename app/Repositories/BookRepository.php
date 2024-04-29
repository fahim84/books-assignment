<?php

namespace App\Repositories;
use App\Models\Book;
use App\Interfaces\BookRepositoryInterface;
use Illuminate\Http\Request;
class BookRepository implements BookRepositoryInterface
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */

    public function index(Request $request): \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|array
    {
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

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id): mixed
    {
        return Book::findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return Book::create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id): mixed
    {
        return Book::whereId($id)->update($data);
    }

    /**
     * @param $id
     */
    public function delete($id){
        Book::destroy($id);
    }
}
