@extends('dashboard.layouts.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-lg-12">
            <h1>Create Transaction</h1>
            <form action="/dashboard/transactions/create">
                @csrf
                <div class="row">
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category_id" id="category_id">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    @if (old('category_id') == $category->id)
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" name="type_id" id="type_id">
                                <option value="">Choose Your Category First</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="size" class="form-label">Size</label>
                            <select class="form-select" name="size_id" id="size_id">
                                <option value="">Choose Your Category First</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="sch" class="form-label">Sch</label>
                            <select class="form-select" name="sch_id" id="sch_id">
                                <option value="">Choose Your Category First</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <select class="form-select" name="rating_id" id="rating_id">
                                <option value="">Choose Your Category First</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="spec" class="form-label">Spec</label>
                            <select class="form-select" name="spec_id" id="spec_id">
                                <option value="">Choose Your Category First</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <select class="form-select" name="brand_id" id="brand_id">
                                <option value="">All Brands</option>
                                @foreach ($brands as $brand)
                                    @if (old('brand_id') == $brand->id)
                                        <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                                    @else
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 mt-4 pt-2">
                        <button type="submit" class="btn btn-primary bg-gradient w-100">Submit</button>
                    </div>
                </div>
            </form>
            <div class="product-list">
                @if(!$products->isEmpty())
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Type</th>
                        <th scope="col">Size</th>
                        <th scope="col">Sch</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Spec</th>
                        <th scope="col">Price Brand</th>
                        <th scope="col">Price Non-Brand</th>
                        <th scope="col">Welding</th>
                        <th scope="col">Penetran</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->type->name }}</td>
                            <td>{{ $product->size->size ?? '' }}</td>
                            <td>{{ $product->sch ? $product->sch->sch : '' }}</td>
                            <td>{{ $product->rating ? $product->rating->rating : '' }}</td>
                            <td>{{ $product->spec ? $product->spec->name : '' }}</td>
                            <td>Rp. {{ number_format($product->price_brand, 2, ',', '.') }}</td>
                            <td>Rp. {{ number_format($product->price_id, 2, ',', '.') }}</td>
                            <td>{{ $product->welding }}</td>
                            <td>{{ $product->penetran }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary select-product" data-product-id="{{ $product->id }}" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapse{{ $loop->iteration }}">
                                    Select
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $products->links('dashboard.layouts.pagination') }}
                </div>
                @else
                    <div class="alert alert-info" role="alert">
                        No products found.
                    </div>
                @endif
                <form action="/dashboard/transactions" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $identifier) }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" readonly>
                        <div id="amountFormatted"></div>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <!-- Placeholder untuk detail produk yang dipilih -->
                    </div>
                    <button type="submit" class="btn btn-success mt-3" id="submitBtn" style="display: none;">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('click', function(event) {
                if (event.target && event.target.classList.contains('select-product')) {
                    const productId = event.target.getAttribute('data-product-id');
                    const parentDiv = event.target.closest('.product-list');
                    const accordionDiv = parentDiv.querySelector('.accordion');

                    if (!accordionDiv) {
                        console.error('Accordion div not found');
                        return;
                    }

                    if (accordionDiv.querySelector(`#collapse${productId}`)) {
                        return;
                    }

                    fetch(`/dashboard/products/${productId}`)
                        .then(response => response.json())
                        .then(data => {
                            const category = data.data.category || { id: '', name: 'Category not added' };
                            const type = data.data.type || { id: '', name: 'Type not added' };
                            const size = data.data.size || { id: '', size: 'Size not added' };
                            const sch = data.data.sch || { id: '', sch: 'Sch not added' };
                            const rating = data.data.rating || { id: '', rating: 'Rating not added' };
                            const spec = data.data.spec || { id: '', name: 'Spec not added' };
                            const brand = data.data.brand || { id: '', name: 'Brand not added' };

                            const priceBrandFormatted = data.data.price_brand ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.data.price_brand) : 'Price Brand not added';
                            const priceIdFormatted = data.data.price_id ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.data.price_id) : 'Price Non-Brand not added';
                            const weldingFormatted = data.data.welding ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.data.welding) : 'Welding not added';
                            const penetranFormatted = data.data.penetran ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.data.penetran) : 'Penetran not added';

                            const newCardDiv = document.createElement('div');
                            newCardDiv.classList.add('accordion-item');

                            const newCardHeaderDiv = document.createElement('div');
                            newCardHeaderDiv.classList.add('accordion-header');

                            const newButton = document.createElement('button');
                            newButton.classList.add('accordion-button', 'collapsed');
                            newButton.setAttribute('type', 'button');
                            newButton.setAttribute('data-bs-toggle', 'collapse');
                            newButton.setAttribute('data-bs-target', `#collapse${productId}`);
                            newButton.setAttribute('aria-expanded', 'false');
                            newButton.setAttribute('aria-controls', `collapse${productId}`);
                            newButton.innerText = `${category.name} - ${type.name} - ${size.size}`;

                            newCardHeaderDiv.appendChild(newButton);
                            newCardDiv.appendChild(newCardHeaderDiv);

                            const newCollapseDiv = document.createElement('div');
                            newCollapseDiv.id = `collapse${productId}`;
                            newCollapseDiv.classList.add('accordion-collapse', 'collapse');
                            newCollapseDiv.setAttribute('aria-labelledby', `heading${productId}`);
                            newCollapseDiv.setAttribute('data-bs-parent', '#accordionExample');

                            const newCardBodyDiv = document.createElement('div');
                            newCardBodyDiv.classList.add('accordion-body');

                            const defaultQuantity = 1; // Set default quantity
                            const defaultTotal = data.data.price_id * defaultQuantity; // Calculate default total

                            newCardBodyDiv.innerHTML = `
                                    <input type="hidden" name="product_id[]" value="${productId}">
                                    <div class="mb-3">
                                        <label for="category${productId}" class="form-label">Category</label>
                                        <select class="form-select" name="category_id" id="category${productId}" disabled>
                                            <option value="${category.id}" selected>${category.name}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="type${productId}" class="form-label">Type</label>
                                        <select class="form-select" name="type_id" id="type${productId}" disabled>
                                            <option value="${type.id}" selected>${type.name}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="size${productId}" class="form-label">Size</label>
                                        <select class="form-select" name="size_id" id="size${productId}" disabled>
                                            <option value="${size.id}" selected>${size.size}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sch${productId}" class="form-label">Sch</label>
                                        <select class="form-select" name="sch_id" id="sch${productId}" disabled>
                                            <option value="${sch.id}" selected>${sch.sch}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rating${productId}" class="form-label">Rating</label>
                                        <select class="form-select" name="rating_id" id="rating${productId}" disabled>
                                            <option value="${rating.id}" selected>${rating.rating}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="spec${productId}" class="form-label">Spec</label>
                                        <select class="form-select" name="spec_id" id="spec${productId}" disabled>
                                            <option value="${spec.id}" selected>${spec.name}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="brand${productId}" class="form-label">Brand</label>
                                        <select class="form-select" name="brand_id" id="brand${productId}" disabled>
                                            <option value="${brand.id}" selected>${brand.name}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price_brand${productId}" class="form-label">Price Brand</label>
                                        <input type="number" class="form-control" id="price_brand${productId}" name="price_brand[]" value="${data.data.price_brand}" readonly>
                                        <div>${priceBrandFormatted}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price_id${productId}" class="form-label">Price Non-Brand</label>
                                        <input type="number" class="form-control" id="price_id${productId}" name="price_id[]" value="${data.data.price_id}" readonly>
                                        <div>${priceIdFormatted}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity${productId}" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="quantity${productId}" name="quantity[]" value="${defaultQuantity}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="total${productId}" class="form-label">Total</label>
                                        <input type="number" class="form-control" id="total${productId}" name="total[]" value="${defaultTotal}" readonly>
                                        <div id="totalFormatted${productId}">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(defaultTotal)}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="welding${productId}" class="form-label">Welding</label>
                                        <input type="text" class="form-control" id="welding${productId}" name="welding[]" value="${data.data.welding ?? 'Welding not added'}" readonly>
                                        <div>${weldingFormatted}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="penetran${productId}" class="form-label">Penetran</label>
                                        <input type="text" class="form-control" id="penetran${productId}" name="penetran[]" value="${data.data.penetran ?? 'Penetran not added'}" readonly>
                                        <div>${penetranFormatted}</div>
                                    </div>
                                `;
                            newCollapseDiv.appendChild(newCardBodyDiv);
                            newCardDiv.appendChild(newCollapseDiv);
                            accordionDiv.appendChild(newCardDiv);

                            updateTotalAmount();

                            const submitBtn = document.getElementById('submitBtn');
                            if (accordionDiv.children.length > 0) {
                                submitBtn.style.display = 'block';
                            }

                            const quantityInput = document.getElementById(`quantity${productId}`);
                            const totalFormattedDiv = document.getElementById(`totalFormatted${productId}`);
                            quantityInput.addEventListener('input', function() {
                                const quantityValue = parseInt(quantityInput.value) || 0;
                                const priceIdValue = parseFloat(data.data.price_id) || 0;
                                const totalValue = quantityValue * priceIdValue;

                                const totalInput = document.getElementById(`total${productId}`);
                                totalInput.value = totalValue;
                                totalFormattedDiv.innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalValue);

                                updateTotalAmount();
                            });

                            function updateTotalAmount() {
                                let totalAmount = 0;
                                const totalInputs = document.querySelectorAll('[id^="total"]');

                                totalInputs.forEach(input => {
                                    const value = parseFloat(input.value);
                                    if (!isNaN(value)) {
                                        totalAmount += value;
                                    }
                                });

                                const amountInput = document.getElementById('amount');
                                const amountFormattedInput = document.getElementById('amountFormatted');
                                amountInput.value = totalAmount;
                                amountFormattedInput.innerHTML = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalAmount);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching product:', error);
                        });
                }
            });
            var categorySelect = document.getElementById('category_id');
            var typeSelect = document.getElementById('type_id');
            var sizeSelect = document.getElementById('size_id');
            var schSelect = document.getElementById('sch_id');
            var ratingSelect = document.getElementById('rating_id');
            var specSelect = document.getElementById('spec_id');

            categorySelect.addEventListener('change', function () {
                var selectedCategoryId = this.value;

                typeSelect.innerHTML = '<option value="">Loading...</option>';
                sizeSelect.innerHTML = '<option value="">Loading...</option>';
                schSelect.innerHTML = '<option value="">Loading...</option>';
                ratingSelect.innerHTML = '<option value="">Loading...</option>';
                specSelect.innerHTML = '<option value="">Loading...</option>';

                fetch('/types?category_id=' + selectedCategoryId)
                    .then(response => response.json())
                    .then(data => {
                        typeSelect.innerHTML = '<option value="">All Types</option>';

                        data.forEach(type => {
                            var option = document.createElement('option');
                            option.value = type.id;
                            option.textContent = type.name;
                            if (type.id == "{{ old('type_id') }}") {
                                option.setAttribute('selected', 'selected');
                            }
                            typeSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching types:', error);
                        typeSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
                fetch('/sizes?category_id=' + selectedCategoryId)
                    .then(response => response.json())
                    .then(data => {
                        sizeSelect.innerHTML = '<option value="">All Sizes</option>';

                        data.forEach(size => {
                            var option = document.createElement('option');
                            option.value = size.id;
                            option.textContent = size.size;
                            if (size.id == "{{ old('size_id') }}") {
                                option.setAttribute('selected', 'selected');
                            }
                            sizeSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        sizeSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
                fetch('/sches?category_id=' + selectedCategoryId)
                    .then(response => response.json())
                    .then(data => {
                        schSelect.innerHTML = '<option value="">All Sches</option>';

                        data.forEach(sch => {
                            var option = document.createElement('option');
                            option.value = sch.id;
                            option.textContent = sch.sch;
                            if (sch.id == "{{ old('sch_id') }}") {
                                option.setAttribute('selected', 'selected');
                            }
                            schSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        schSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
                fetch('/ratings?category_id=' + selectedCategoryId)
                    .then(response => response.json())
                    .then(data => {
                        ratingSelect.innerHTML = '<option value="">All Ratings</option>';

                        data.forEach(rating => {
                            var option = document.createElement('option');
                            option.value = rating.id;
                            option.textContent = rating.rating;
                            if (rating.id == "{{ old('rating_id') }}") {
                                option.setAttribute('selected', 'selected');
                            }
                            ratingSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        ratingSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
                fetch('/specs?category_id=' + selectedCategoryId)
                    .then(response => response.json())
                    .then(data => {
                        specSelect.innerHTML = '<option value="">All Specs</option>';

                        data.forEach(spec => {
                            var option = document.createElement('option');
                            option.value = spec.id;
                            option.textContent = spec.name;
                            if (spec.id == "{{ old('spec_id') }}") {
                                option.setAttribute('selected', 'selected');
                            }
                            specSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        specSelect.innerHTML = '<option value="">Error loading types</option>';
                    });
            });

            var initialCategoryId = categorySelect.value;

            if (initialCategoryId) {
                categorySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>

{{--    <form action="{{ route('transactions.store') }}" method="POST">--}}
{{--        @csrf--}}
{{--        <div class="accordion" id="accordionExample">--}}
{{--            <div class="accordion-item">--}}
{{--                <div class="accordion-header" id="heading0">--}}
{{--                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse0" aria-expanded="true" aria-controls="collapse0">--}}
{{--                        Item 1--}}
{{--                    </button>--}}
{{--                </div>--}}

{{--                <div id="collapse0" class="accordion-collapse collapse show" aria-labelledby="heading0" data-bs-parent="#accordionExample">--}}
{{--                    <div class="accordion-body">--}}
{{--                        <div class="transaction-item mb-5">--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="category" class="form-label">Category</label>--}}
{{--                                <select class="form-select category_id" name="category_id[]" id="category_id0">--}}
{{--                                    <option value="">All Categories</option>--}}
{{--                                    @foreach ($categories as $category)--}}
{{--                                        <option value="{{ $category->id }}">{{ $category->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="type" class="form-label">Type</label>--}}
{{--                                <select class="form-select type_id" name="type_id[]" id="type_id0">--}}
{{--                                    <option value="">Choose Your Category First</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="size" class="form-label">Size</label>--}}
{{--                                <select class="form-select size_id" name="size_id[]" id="size_id0">--}}
{{--                                    <option value="">Choose Your Category First</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="sch" class="form-label">Sch</label>--}}
{{--                                <select class="form-select sch_id" name="sch_id[]" id="sch_id0">--}}
{{--                                    <option value="">Choose Your Category First</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="rating" class="form-label">Rating</label>--}}
{{--                                <select class="form-select rating_id" name="rating_id[]" id="rating_id0">--}}
{{--                                    <option value="">Choose Your Category First</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="spec" class="form-label">Spec</label>--}}
{{--                                <select class="form-select spec_id" name="spec_id[]" id="spec_id0">--}}
{{--                                    <option value="">Choose Your Category First</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="brand" class="form-label">Brand</label>--}}
{{--                                <select class="form-select" name="brand_id[]" id="brand_id0">--}}
{{--                                    <option value="">All Brands</option>--}}
{{--                                    @foreach ($brands as $brand)--}}
{{--                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="price_brand" class="form-label">Price Brand</label>--}}
{{--                                <input type="number" class="form-control" id="price_brand0" name="price_brand[]" value="{{ old('price_brand') }}">--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="price_id" class="form-label">Price Non-Brand</label>--}}
{{--                                <input type="number" class="form-control" id="price_id0" name="price_id[]" value="{{ old('price_id') }}">--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="welding" class="form-label">Welding</label>--}}
{{--                                <input type="text" class="form-control" id="welding0" name="welding[]" value="{{ old('welding') }}">--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <label for="penetran" class="form-label">Penetran</label>--}}
{{--                                <input type="text" class="form-control" id="penetran0" name="penetran[]" value="{{ old('penetran') }}">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <button type="button" class="btn btn-primary mt-3" id="add-item-button">Tambah Item</button>--}}
{{--        <button type="submit" class="btn btn-success mt-3">Submit</button>--}}
{{--    </form>--}}

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const accordionExample = document.getElementById('accordionExample');--}}

{{--            function handleCategoryChange(categorySelect) {--}}
{{--                const selectedCategoryId = categorySelect.value;--}}
{{--                const parentDiv = categorySelect.closest('.transaction-item');--}}
{{--                const typeSelect = parentDiv.querySelector('.type_id');--}}
{{--                const sizeSelect = parentDiv.querySelector('.size_id');--}}
{{--                const schSelect = parentDiv.querySelector('.sch_id');--}}
{{--                const ratingSelect = parentDiv.querySelector('.rating_id');--}}
{{--                const specSelect = parentDiv.querySelector('.spec_id');--}}

{{--                typeSelect.innerHTML = '<option value="">Loading...</option>';--}}
{{--                sizeSelect.innerHTML = '<option value="">Loading...</option>';--}}
{{--                schSelect.innerHTML = '<option value="">Loading...</option>';--}}
{{--                ratingSelect.innerHTML = '<option value="">Loading...</option>';--}}
{{--                specSelect.innerHTML = '<option value="">Loading...</option>';--}}

{{--                fetch('/types?category_id=' + selectedCategoryId)--}}
{{--                    .then(response => response.json())--}}
{{--                    .then(data => {--}}
{{--                        typeSelect.innerHTML = '<option value="">All Types</option>';--}}
{{--                        data.forEach(type => {--}}
{{--                            const option = document.createElement('option');--}}
{{--                            option.value = type.id;--}}
{{--                            option.textContent = type.name;--}}
{{--                            typeSelect.appendChild(option);--}}
{{--                        });--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        console.error('Error fetching types:', error);--}}
{{--                        typeSelect.innerHTML = '<option value="">Error loading types</option>';--}}
{{--                    });--}}

{{--                fetch('/sizes?category_id=' + selectedCategoryId)--}}
{{--                    .then(response => response.json())--}}
{{--                    .then(data => {--}}
{{--                        sizeSelect.innerHTML = '<option value="">All Sizes</option>';--}}
{{--                        data.forEach(size => {--}}
{{--                            const option = document.createElement('option');--}}
{{--                            option.value = size.id;--}}
{{--                            option.textContent = size.size;--}}
{{--                            sizeSelect.appendChild(option);--}}
{{--                        });--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        sizeSelect.innerHTML = '<option value="">Error loading types</option>';--}}
{{--                    });--}}

{{--                fetch('/sches?category_id=' + selectedCategoryId)--}}
{{--                    .then(response => response.json())--}}
{{--                    .then(data => {--}}
{{--                        schSelect.innerHTML = '<option value="">All Sches</option>';--}}
{{--                        data.forEach(sch => {--}}
{{--                            const option = document.createElement('option');--}}
{{--                            option.value = sch.id;--}}
{{--                            option.textContent = sch.sch;--}}
{{--                            schSelect.appendChild(option);--}}
{{--                        });--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        schSelect.innerHTML = '<option value="">Error loading types</option>';--}}
{{--                    });--}}

{{--                fetch('/ratings?category_id=' + selectedCategoryId)--}}
{{--                    .then(response => response.json())--}}
{{--                    .then(data => {--}}
{{--                        ratingSelect.innerHTML = '<option value="">All Ratings</option>';--}}
{{--                        data.forEach(rating => {--}}
{{--                            const option = document.createElement('option');--}}
{{--                            option.value = rating.id;--}}
{{--                            option.textContent = rating.rating;--}}
{{--                            ratingSelect.appendChild(option);--}}
{{--                        });--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        ratingSelect.innerHTML = '<option value="">Error loading types</option>';--}}
{{--                    });--}}

{{--                fetch('/specs?category_id=' + selectedCategoryId)--}}
{{--                    .then(response => response.json())--}}
{{--                    .then(data => {--}}
{{--                        specSelect.innerHTML = '<option value="">All Specs</option>';--}}
{{--                        data.forEach(spec => {--}}
{{--                            const option = document.createElement('option');--}}
{{--                            option.value = spec.id;--}}
{{--                            option.textContent = spec.name;--}}
{{--                            specSelect.appendChild(option);--}}
{{--                        });--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        specSelect.innerHTML = '<option value="">Error loading types</option>';--}}
{{--                    });--}}
{{--            }--}}

{{--            function handleProductInfoChange(productInfoSelect) {--}}
{{--                const selectedProductInfoId = productInfoSelect.value;--}}
{{--                const parentDiv = productInfoSelect.closest('.transaction-item');--}}
{{--                const brandSelect = parentDiv.querySelector('.brand_id');--}}
{{--                const priceBrandInput = parentDiv.querySelector('.price_brand');--}}
{{--                const priceIdInput = parentDiv.querySelector('.price_id');--}}
{{--                const weldingInput = parentDiv.querySelector('.welding');--}}
{{--                const penetranInput = parentDiv.querySelector('.penetran');--}}

{{--                brandSelect.innerHTML = '<option value="">Loading...</option>';--}}
{{--                priceBrandInput.value = '';--}}
{{--                priceIdInput.value = '';--}}
{{--                weldingInput.value = '';--}}
{{--                penetranInput.value = '';--}}

{{--                fetch('/dashboard/check-product?' + selectedProductInfoId)--}}
{{--                    .then(response => response.json())--}}
{{--                    .then(data => {--}}
{{--                        brandSelect.innerHTML = '<option value="">All Brands</option>';--}}
{{--                        data.brands.forEach(brand => {--}}
{{--                            const option = document.createElement('option');--}}
{{--                            option.value = brand.id;--}}
{{--                            option.textContent = brand.name;--}}
{{--                            brandSelect.appendChild(option);--}}
{{--                        });--}}

{{--                        priceBrandInput.value = data.price_brand;--}}
{{--                        priceIdInput.value = data.price_id;--}}
{{--                        weldingInput.value = data.welding;--}}
{{--                        penetranInput.value = data.penetran;--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        console.error('Error fetching product info:', error);--}}
{{--                        brandSelect.innerHTML = '<option value="">Error loading brands</option>';--}}
{{--                    });--}}
{{--            }--}}

{{--            accordionExample.addEventListener('change', function(event) {--}}
{{--                if (event.target.classList.contains('category_id')) {--}}
{{--                    handleCategoryChange(event.target);--}}
{{--                }--}}
{{--            });--}}

{{--            let itemCount = 1;--}}
{{--            document.getElementById('add-item-button').addEventListener('click', function() {--}}
{{--                const accordionDiv = document.getElementById('accordionExample');--}}
{{--                const newCardDiv = document.createElement('div');--}}
{{--                newCardDiv.classList.add('accordion-item');--}}

{{--                const newCardHeaderDiv = document.createElement('div');--}}
{{--                newCardHeaderDiv.classList.add('accordion-header');--}}
{{--                newCardHeaderDiv.id = `heading${itemCount}`;--}}

{{--                const newButton = document.createElement('button');--}}
{{--                newButton.classList.add('accordion-button', 'collapsed');--}}
{{--                newButton.setAttribute('type', 'button');--}}
{{--                newButton.setAttribute('data-bs-toggle', 'collapse');--}}
{{--                newButton.setAttribute('data-bs-target', `#collapse${itemCount}`);--}}
{{--                newButton.setAttribute('aria-expanded', 'false');--}}
{{--                newButton.setAttribute('aria-controls', `collapse${itemCount}`);--}}
{{--                newButton.innerText = `Item ${itemCount + 1}`;--}}

{{--                newCardHeaderDiv.appendChild(newButton);--}}
{{--                newCardDiv.appendChild(newCardHeaderDiv);--}}

{{--                const newCollapseDiv = document.createElement('div');--}}
{{--                newCollapseDiv.id = `collapse${itemCount}`;--}}
{{--                newCollapseDiv.classList.add('accordion-collapse', 'collapse');--}}
{{--                newCollapseDiv.setAttribute('aria-labelledby', `heading${itemCount}`);--}}
{{--                newCollapseDiv.setAttribute('data-bs-parent', '#accordionExample');--}}

{{--                const newCardBodyDiv = document.createElement('div');--}}
{{--                newCardBodyDiv.classList.add('accordion-body');--}}

{{--                newCardBodyDiv.innerHTML = `--}}
{{--                    <div class="transaction-item">--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="category" class="form-label">Category</label>--}}
{{--                            <select class="form-select category_id" name="category_id[]" id="category_id${itemCount}">--}}
{{--                                <option value="">All Categories</option>--}}
{{--                                @foreach ($categories as $category)--}}
{{--                <option value="{{ $category->id }}">{{ $category->name }}</option>--}}
{{--                                @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="mb-3">--}}
{{--                <label for="type" class="form-label">Type</label>--}}
{{--                <select class="form-select type_id" name="type_id[]" id="type_id${itemCount}">--}}
{{--                                <option value="">Choose Your Category First</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="size" class="form-label">Size</label>--}}
{{--                            <select class="form-select size_id" name="size_id[]" id="size_id${itemCount}">--}}
{{--                                <option value="">Choose Your Category First</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="sch" class="form-label">Sch</label>--}}
{{--                            <select class="form-select sch_id" name="sch_id[]" id="sch_id${itemCount}">--}}
{{--                                <option value="">Choose Your Category First</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="rating" class="form-label">Rating</label>--}}
{{--                            <select class="form-select rating_id" name="rating_id[]" id="rating_id${itemCount}">--}}
{{--                                <option value="">Choose Your Category First</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="spec" class="form-label">Spec</label>--}}
{{--                            <select class="form-select spec_id" name="spec_id[]" id="spec_id${itemCount}">--}}
{{--                                <option value="">Choose Your Category First</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="brand" class="form-label">Brand</label>--}}
{{--                            <select class="form-select" name="brand_id[]" id="brand_id${itemCount}">--}}
{{--                                <option value="">All Brands</option>--}}
{{--                                @foreach ($brands as $brand)--}}
{{--                <option value="{{ $brand->id }}">{{ $brand->name }}</option>--}}
{{--                                @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="mb-3">--}}
{{--                <label for="price_brand" class="form-label">Price Brand</label>--}}
{{--                <input type="number" class="form-control" id="price_brand${itemCount}" name="price_brand[]" value="{{ old('price_brand') }}">--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="price_id" class="form-label">Price Non-Brand</label>--}}
{{--                            <input type="number" class="form-control" id="price_id${itemCount}" name="price_id[]" value="{{ old('price_id') }}">--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="welding" class="form-label">Welding</label>--}}
{{--                            <input type="text" class="form-control" id="welding${itemCount}" name="welding[]" value="{{ old('welding') }}">--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="penetran" class="form-label">Penetran</label>--}}
{{--                            <input type="text" class="form-control" id="penetran${itemCount}" name="penetran[]" value="{{ old('penetran') }}">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                `;--}}

{{--                newCollapseDiv.appendChild(newCardBodyDiv);--}}
{{--                newCardDiv.appendChild(newCollapseDiv);--}}
{{--                accordionDiv.appendChild(newCardDiv);--}}

{{--                itemCount++;--}}
{{--            });--}}

{{--            var initialCategorySelects = document.querySelectorAll('.category_id');--}}
{{--            initialCategorySelects.forEach(categorySelect => {--}}
{{--                var initialCategoryId = categorySelect.value;--}}
{{--                if (initialCategoryId) {--}}
{{--                    handleCategoryChange(categorySelect);--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endsection
