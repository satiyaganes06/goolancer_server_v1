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
                <h4 class="mb-3 mb-md-0 text-center">Services</h4>
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

            <div id="servicesGrid" class="row row-cols-1 row-cols-md-3 g-4 mt-3">
                <!-- Your service cards here -->
                @foreach ($services as $service)
                    <div class="col">
                        <a href="{{route('admin.viewServiceInfo', ['id' => $service->es_int_ref, 'from' => 0])}}">
                            <div class="card rounded-3">
                                <div class="image-container">
                                    <img src="http://goolancer.online/user/displayImage/{{ $service->es_var_images }}"
                                        class="card-img-top rounded-3" alt="...">

                                        @if ($service->es_bool_isInHouseExpert == 1)
                                            <div class="overlay" style="font-size: 10px">In-House Expert</div>
                                        @else

                                        @endif

                                </div>
                                <div class="card-body">
                                    <p class="card-text width ellipse two-lines text-dark">
                                        {{ $service->es_txt_description }}</p>
                                    <div class="d-flex d-flex justify-content-between align-items-end mt-3">
                                        <div class="d-flex align-items-end">
                                            <i class="link-icon text-warning" data-feather="star" style="height: 20px"></i>
                                            <p class="card-text width ellipse two-lines text-warning ml-1">
                                                {{ $service->es_fl_average_rating }}</p>
                                        </div>
                                        <div class="d-flex align-items-end">
                                            <p class="fs-6 text-dark" style="padding-bottom: 2px">from &nbsp;</p>
                                            <p class="fs-4 text-dark"> RM {{ $service->es_var_starting_price }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                {{ $services->links('pagination::bootstrap-5') }}
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
