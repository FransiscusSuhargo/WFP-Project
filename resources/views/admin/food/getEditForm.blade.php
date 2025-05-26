<div class="">
    <form id="edit-food-form" action="{{ route('food.update') }}" method="POST" class="form-control">
        @csrf
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">ID</label>
            <input type="number" class="form-control-plaintext" id="exampleFormControlInput1" name="id"
                value="{{ $food->id }}" readonly>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Name</label>
            <input name="name" type="text" class="form-control" id="exampleFormControlInput1"
                value="{{ $food->name }}" placeholder="Enter food name">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Description</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="description"
                value="{{ $food->description }}" placeholder="Enter food description">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nutrition Value</label>
            <textarea name="nutrition" type="text" class="form-control" id="exampleFormControlInput1"
                placeholder="Enter food Nutrition">{{ $food->nutrition_value }}</textarea>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" id="exampleFormControlInput1"
                placeholder="Enter food Price" value="{{ $food->price }}"></input>
        </div>
        <div class="mb-3">
            <label for="defaultSelect" class="form-label">Category</label>
            <select id="category" class="form-select" name="category">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" id="updateFood" class="btn btn-primary w-100">UPDATE</button>
    </form>
</div>