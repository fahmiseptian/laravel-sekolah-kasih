<!doctype html>
<html lang="en">

@include('partials.css')


<body>

    <main class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        @include('partials.sidebar')
        <div class="body-wrapper">
            @include('partials.navbar')
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table text-nowrap align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php $no = 1; ?>
                            <tr>
                                <td>
                                    <?= $no++ ?>
                                </td>
                                <td>Online Course</td>
                                <td>Popup</td>
                                <td>publish</td>
                                <td>
                                    <a href="{{ env('URL_WP') }}/auto-login?token={{ env('TOKEN_WP') }}&post=497" class="btn btn-sm btn-primary" title="Edit Elementor" target="_blank">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?= $no++ ?>
                                </td>
                                <td>Competitions</td>
                                <td>Popup</td>
                                <td>publish</td>
                                <td>
                                    <a href="{{ env('URL_WP') }}/auto-login?token={{ env('TOKEN_WP') }}&post=494" class="btn btn-sm btn-primary" title="Edit Elementor" target="_blank">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?= $no++ ?>
                                </td>
                                <td>Summer Camps</td>
                                <td>Popup</td>
                                <td>publish</td>
                                <td>
                                    <a href="{{ env('URL_WP') }}/auto-login?token={{ env('TOKEN_WP') }}&post=490" class="btn btn-sm btn-primary" title="Edit Elementor" target="_blank">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?= $no++ ?>
                                </td>
                                <td>Homeschooling</td>
                                <td>Popup</td>
                                <td>publish</td>
                                <td>
                                    <a href="{{ env('URL_WP') }}/auto-login?token={{ env('TOKEN_WP') }}&post=483" class="btn btn-sm btn-primary" title="Edit Elementor" target="_blank">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?= $no++ ?>
                                </td>
                                <td>Virtual Programs</td>
                                <td>Popup</td>
                                <td>publish</td>
                                <td>
                                    <a href="{{ env('URL_WP') }}/auto-login?token={{ env('TOKEN_WP') }}&post=480" class="btn btn-sm btn-primary" title="Edit Elementor" target="_blank">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?= $no++ ?>
                                </td>
                                <td>After School</td>
                                <td>Popup</td>
                                <td>publish</td>
                                <td>
                                    <a href="{{ env('URL_WP') }}/auto-login?token={{ env('TOKEN_WP') }}&post=463" class="btn btn-sm btn-primary" title="Edit Elementor" target="_blank">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    @include('partials.js')
</body>