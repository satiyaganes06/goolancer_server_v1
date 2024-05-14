@extends('admin.admin_dashboard')
@section('admin_content')
    <style>
        .searchLogo {
            background-color: aliceblue;
            border: 0 !important;
            border-radius: 20px 0 0 20px !important;
        }

        .searchField {
            border: 0 !important;
            border-radius: 0 20px 20px 0 !important;
        }

        .ellipse {
            white-space: nowrap;
            display: inline-block;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: justify
        }

        .two-lines {
            -webkit-line-clamp: 5;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            white-space: normal;
        }

        .width {
            width: auto;
        }

        .image-container {
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(95, 158, 57, 255);
            border-radius: 50px;
            /* Change as needed */
            color: white;
            /* Change as needed */
            padding: 5px;
            margin-top: 10px;
            margin-left: 10px;
            /* Change as needed */
        }
    </style>
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div class="w-100">
                <h4 class="mb-3 mb-md-0 text-center">Certificates</h4>
            </div>
            <form class="d-flex input-group  mr-4 justify-content-center"
                style="margin-right: 20%; margin-left: 20%; margin-top:30px" action="" method="GET">

                <span class="input-group-text searchLogo bg-light" id="search-addon">
                    <button type="submit" class="border-0 bg-light"><i class="link-icon"
                            data-feather="search"></i></button>
                </span>

                <input type="search" id="form1" class="form-control searchField bg-light" name="searchTerm"
                    placeholder="Search" aria-label="Search" aria-describedby="search-addon" onkeyup="myFunction()" />

            </form>
            <div class="example">
                <!-- Button trigger modal -->



                <div id="servicesGrid" class="row row-cols-1 row-cols-md-3 g-4 mt-3">
                    <!-- Your service cards here -->
                    @foreach ($certs as $cert)
                        <div class="col">

                            <a data-bs-toggle="modal" data-bs-target="#exampleModalLongScollable">
                                <div class="card rounded-3">
                                    <div class="image-container">
                                        <img src="http://goolancer.online/user/displayImage/{{ $cert->ec_var_image }}"
                                            class="card-img-top rounded-3" alt="...">


                                    </div>

                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    {{ $certs->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalLongScollable" tabindex="-1" aria-labelledby="exampleModalScrollableTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in,
                            egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel
                            augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque
                            nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                        <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in,
                            egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel
                            augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque
                            nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                        <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in,
                            egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel
                            augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque
                            nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                        <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in,
                            egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel
                            augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque
                            nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                        <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in,
                            egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel
                            augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque
                            nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                        <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in,
                            egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel
                            augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque
                            nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function myFunction() {
            var input, filter, cards, card, description, i, txtValue;
            input = document.getElementById("form1");
            filter = input.value.toUpperCase();
            cards = document.getElementsByClassName("col"); // Select the card containers

            for (i = 0; i < cards.length; i++) {
                card = cards[i];
                description = card.querySelector(".card-text");

                if (description) {
                    txtValue = description.textContent || description.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        card.style.display = "block"; // Show the card
                    } else {
                        card.style.display = "none"; // Hide the card
                    }
                }
            }

            // Reorganize the layout of visible cards
            var visibleCards = document.querySelectorAll('.col[style="display: block;"]');
            var row = document.querySelector('.row');
            var columnCount = row.getAttribute('class').split(' ').find(cls => cls.startsWith('row-cols-')).split('-')[2];
            var newRow = document.createElement('div');
            newRow.className = 'row row-cols-1 row-cols-md-' + columnCount;
            for (var j = 0; j < visibleCards.length; j++) {
                var visibleCard = visibleCards[j];
                newRow.appendChild(visibleCard);
            }
            row.innerHTML = newRow.innerHTML;
        }
    </script>
@endsection
