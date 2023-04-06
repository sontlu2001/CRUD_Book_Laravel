## Đề bài:
Cho CSDL như sau:
- Book (id,title:varchar-50, published_date:date, description: varchar:300, author_id:int,)
- Category (id,name: varchar-50)
- Author (id,name: varchar-50,email:varchar-50)

Một cuốn sách thuộc về một tác giả. Một thể loại có nhiều quyển sách và một quyển sách có thể thuộc về nhiều thể loại khác nhau.

===================== Hãy tạo thêm các table nếu cần thiết ====================

Yêu cầu:
1)	Tạo các DB hoàn chỉnh theo mô tả trên.
2)	Sử dụng factory và seeder sinh 10 fake data cho mỗi table.
3)	Xây dựng giao diện phù hợp thực hiện chức năng CRUD Book, Category, Author.
4)	Thực hiện phân quyền user: 
## Step by steps
### Step 1. Khởi tạo project.
```
composer create-project laravel/laravel ManageBooks
```
### Step 2. Cấu hình DB_DATABASE file .env
```
DB_DATABASE=books
```
### Step 3. Tạo các migrations, seeder, controller, model cần thiết.
```
php artisan make:model Category -mfc --resource
php artisan make:model Author -mfc --resource
php artisan make:model Book -mfc --resource
php artisan make:model BookCategory -mf
```

### Step 4. Chỉnh sửa các Migrations.
#### database\migrations\2023_04_05_012629_create_categories_table.php
```
 public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
```
#### database\migrations\2023_04_05_012701_create_authors_table.php
```
public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('email',50)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
```
#### database\migrations\2023_04_05_015439_book.php
```
public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title',50);
            $table->date('published_date');
            $table->string('description',300);
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('authors');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
```
#### database\migrations\2023_04_05_085247_create_book_category_table.php
```
public function up(): void
    {
        Schema::create('book_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_categories');
    }
```

### Step 5. Chỉnh sửa các Models.
#### app\Models\Category.php
```
class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    public function books(){
        return $this->belongsToMany(Book::class);
    }
    public function getData($perPage = 10)
    {
        $categories = $this->select('categories.*')->orderBy('created_at','desc') -> paginate($perPage);
        return $categories;
    }
    public function getAllCategories()
    {
        $category = Category::all();
        return $category;
    }
}
```

#### app\Models\Author.php
```
  class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getAllAuthors(){
        return Author::all();
    }
}
``` 

#### app\Models\Book.php
```
   class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title','published_date', 'description', 'author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getData($perPage = 10)
    {
        $books = $this->select('books.*')->orderBy('created_at','desc') -> paginate($perPage);
        return $books;
    }

}
```

#### app\Models\BookCategory.php
```
    use HasFactory;
    protected $fillable = ["book_id","category_id"];
```

### Step 6. Using Factory & Seeder fake datas.
#### database\factories\AuthorFactory.php
```
public function definition(): array
    {
        return [
            "name" => fake()-> unique()->name(),
            "email" => fake()->unique()->email(),
        ];
    }
```
#### database\factories\CategoryFactory.php
```
    public function definition(): array
    {
        return [
            "name" => fake()->unique()->randomElement([
                'Alternate history',
                'Autobiography',
                'Anthology',
                'Biography',
                'Classic',
                'Cookbook',
                'Comic book',
                'Diary',
                'Dictionary',
                'Encyclopedia',
                'Drama',
                'Guide',
                'Fairytale',
                'Health/fitness',
                'Fantasy',
                'History',
                'Humor',
                'Horror',
                'Science'
            ])
        ];
    }
```
#### database\factories\BookFactory.php
```
public function definition(): array
    {
        return [
            "title" => fake()->text(20),
            "published_date" => fake()->date(),
            "description" => fake()->text(),
            "author_id" => fake()->numberBetween(1, 10),
        ];
    }
```
#### database\factories\BookCategoryFactory.php
```
    public function definition(): array
    {
        return [
          'book_id' => Book::all()->random()->id,
            'category_id' => Category::all()->random()->id,
        ];

    }
```
#### database\seeders\DatabaseSeeder.php
```
  public function run(): void
    {
        Author::factory(10)->create();
        Category::factory(10)->create();
        Book::factory(10)->create();
        BookCategory::factory(10)->create();
    }
```
Run Seeder
```
php artisan db:seed
```
**CHÚ Ý: Sau khi tạo data xong bắt buộc phải đổi lại tên bảng book_categories trong CSDL bằng câu lệnh**
```
ALTER TABLE book_categories RENAME TO book_category;
```