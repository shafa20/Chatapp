<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Image CRUD Operations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif


                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                    <!-- Add Image Form -->
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#addImageModal">Add Image</button>

                    <!-- Display Images -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($images as $image)
                                <tr>
                                    <td>{{ $image->name }}</td>
                                    <td>{{ $image->description }}</td>
                                    <td><img src="{{ asset('images/' . $image->image) }}" alt="{{ $image->name }}"
                                            style="max-width: 100px;"></td>
                                    <td>
                                        <!-- Edit Button (Open Modal) -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editImageModal_{{ $image->id }}">Edit</button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#showImageModal_{{ $image->id }}">Show</button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('onepage.destroy', $image->id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this image?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Edit Image Modal -->
                                <div class="modal fade" id="editImageModal_{{ $image->id }}" tabindex="-1"
                                    aria-labelledby="editImageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editImageModalLabel">Edit Image</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Edit Image Form -->
                                                <form action="{{ route('onepage.update', $image->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="name">Name:</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ $image->name }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Description:</label>
                                                        <textarea class="form-control" id="description" name="description">{{ $image->description }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="new_image">New Image:</label>
                                                        <img src="{{ asset('images/' . $image->image) }}" alt="{{ $image->name }}"
                                            style="max-width: 100px;">
                                                        <input type="file" class="form-control" id="new_image"
                                                            name="new_image">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <!-- Show Image Modal -->
                                 <div class="modal fade" id="showImageModal_{{ $image->id }}" tabindex="-1"
                                    aria-labelledby="editImageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editImageModalLabel">Show Post</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Edit Image Form -->
                                                <form >


                                                    <div class="form-group">
                                                        <label for="name">Name:</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ $image->name }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Description:</label>
                                                        <textarea class="form-control" id="description" name="description" readonly>{{ $image->description }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="new_image">New Image:</label>
                                                        <img src="{{ asset('images/' . $image->image) }}" alt="{{ $image->name }}"
                                                         style="max-width: 100px;">

                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Close</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4">No images found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $images->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addImageModalLabel">Add Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Image Form -->
                    <form action="{{ route('onepage.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description:<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Image:<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="image" name="image" required>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
