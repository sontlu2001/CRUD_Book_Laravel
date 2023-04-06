<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookModel = new Book();
        $data = $bookModel -> getData(5);
        return view('books.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryModel = new Category();
        $authorModel = new Author();
        $categories =  $categoryModel->getAllCategories();
        $authors = $authorModel ->getAllAuthors();

        return view('books.create', compact('categories','authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:50',
            'published_date' => 'required|date',
            'description' => 'required|max:300',
            'author_id' => 'required|numeric',
            'categories' => 'required|array'
        ]);

        // Create book
        $book = Book::create([
            'title' => $validatedData['title'],
            'author_id' => $validatedData['author_id'],
            'published_date' => $validatedData['published_date'],
            'description' => $validatedData['description'],
        ]);

        // Attach categories to book
        $book->categories()->attach($validatedData['categories']);

        return redirect()->route('book.index')->with('success', 'Book created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show',compact('book'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categoryModel = new Category();
        $authorModel = new Author();
        $categories =  $categoryModel->getAllCategories();
        $authors = $authorModel ->getAllAuthors();

        return view('books.edit',compact('book','categories','authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {

        $request->validate([
            'title' => 'required|max:50',
            'published_date' => 'required|date',
            'description' => 'required|max:300',
            'author_id' => 'required|numeric'
        ]);

        // Lấy ra thông tin của cuốn sách cần cập nhật
        $book = Book::findOrFail($id);

        // Cập nhật thông tin sách
        $book->title = $request->input('title');
        $book->author_id = $request->input('author_id');
        $book->published_date = $request->input('published_date');
        $book->description = $request->input('description');

        // Cập nhật danh mục sách
        $categories = $request->input('categories');
        $book->categories()->sync($categories);

        // Lưu lại thông tin sách
        $book->save();

        return redirect()->route('book.index')->with('success','Book has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book.index')->with('success','Book has been deleted successfully');

    }
}
