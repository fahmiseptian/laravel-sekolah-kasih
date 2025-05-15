<!doctype html>
<html lang="en">

@include('partials.css')

<body>
    <main class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('partials.sidebar')
        <div class="body-wrapper">
            @include('partials.navbar')
            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Banner Management</h4>
                        <div class="row">
                            @foreach($banner as $index => $item)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="{{ $item['image_url'] }}" class="card-img-top" alt="Banner {{ $index + 1 }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <input type="text" id="direct_link_{{ $index }}" value="{{ url($item['direct_link']) }}" class="form-control mb-2">
                                        <a href="#" onclick="deleteBanner({{$index}})" class="btn btn-danger btn-sm">Hapus</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            @for ($i = count($banner); $i < 3; $i++)
                                <div class="col-md-4 mb-4">
                                <div class="card d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#addBannerModal" class="text-muted text-center">
                                        <i class="material-symbols-outlined" style="font-size: 48px;">add</i>
                                        <p>Add New Banner</p>
                                    </a>
                                </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- Add Banner Modal -->
        <div class="modal fade" id="addBannerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addBannerForm">
                            <div class="mb-3">
                                <label for="bannerImage" class="form-label">Banner Image (URL or File)</label>
                                <input type="text" class="form-control mb-2" id="imageUrl" placeholder="Enter Image URL" oninput="previewBanner()">
                                <input type="file" class="form-control" id="imageFile" accept="image/*" onchange="previewBanner()">
                                <div class="mt-3 text-center">
                                    <img id="bannerPreview" src="#" alt="Banner Preview" style="max-width: 100%; max-height: 200px; display: none;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="directUrl" class="form-label">Direct URL</label>
                                <input type="text" class="form-control" id="directUrl" placeholder="Enter Direct URL">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="saveBanner()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.js')
    <script>
        function deleteBanner(index) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/banner/${index}`,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Banner has been deleted.',
                            }).then(() => location.reload());
                            // Refresh the banner list or remove the deleted banner from the UI
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            }).then(() => location.reload());
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr, status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    }
                });
            }
            })
        }

        function previewBanner() {
            const imageUrl = $('#imageUrl').val().trim();
            const imageFile = $('#imageFile')[0].files[0];
            const preview = $('#bannerPreview');

            if (imageFile) {
                preview.attr('src', URL.createObjectURL(imageFile));
                preview.show();
                $('#imageUrl').val('');
            } else if (imageUrl) {
                preview.attr('src', imageUrl);
                preview.show();
                $('#imageFile').val('');
            } else {
                preview.hide();
            }
        }

        function saveBanner() {
            const imageUrl = $('#imageUrl').val().trim();
            const imageFile = $('#imageFile')[0].files[0];
            const directUrl = $('#directUrl').val().trim();

            if (imageFile && imageFile.size > 2000000) {
                Swal.fire({
                    icon: 'error',
                    title: 'The image file size must not exceed 2MB.',
                    text: 'Please upload a smaller image file.',
                });
                return;
            }

            if (!imageUrl && !imageFile) {
                Swal.fire({
                    icon: 'error',
                    title: 'Please provide an image URL or upload an image file.'
                });
                return;
            }

            if (!directUrl) {
                Swal.fire({
                    icon: 'error',
                    title: 'Please provide a direct URL.',
                });
                return;
            }

            const formData = new FormData();
            if (imageFile) {
                formData.append('imageFile', imageFile);
            } else {
                formData.append('imageUrl', imageUrl);
            }
            formData.append('directUrl', directUrl);

            $.ajax({
                url: '/api/banner/add', 
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Banner successfully saved.',
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Failed to save banner.',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'An error occurred while saving the banner.',
                    });
                }
            });
        }
    </script>
</body>

</html>