<!-- resources/views/components/footer.blade.php -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Appointment-related JS
    $(document).ready(function() {
        // Filter pets based on selected client
        $('#client_id').change(function() {
            var clientId = $(this).val();
            $('#pet_id option').each(function() {
                var petClientId = $(this).data('client-id');
                if (petClientId == clientId || clientId === '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $('#pet_id').val(''); // Reset pet selection
        });

        // For edit modal
        $('.edit-btn').click(function() {
            var appointmentId = $(this).data('id');
            $('#editAppointmentForm').attr('action', '/appointments/' + appointmentId);
            
            // Populate form fields
            $('#edit-client_id').val($(this).data('client_id'));
            $('#edit-pet_id').val($(this).data('pet_id'));
            $('#edit-clinic_id').val($(this).data('clinic_id'));
            $('#edit-vet_id').val($(this).data('vet_id'));
            $('#edit-appointment_datetime').val($(this).data('appointment_datetime'));
            $('#edit-duration_minutes').val($(this).data('duration_minutes'));
            $('#edit-status').val($(this).data('status'));
            $('#edit-notes').val($(this).data('notes'));
        });

        // Update pet options when client changes in edit modal
        $('#edit-client_id').change(function() {
            var clientId = $(this).val();
            $('#edit-pet_id option').each(function() {
                var petClientId = $(this).data('client-id');
                if (petClientId == clientId || clientId === '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Calendar initialization
        if (document.getElementById('calendar')) {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {!! json_encode($events ?? []) !!},
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    
                    if (info.event.url) {
                        $.get(info.event.url, function(data) {
                            $('#appointmentDetails').html(data);
                            $('#editAppointmentBtn').attr('href', info.event.url.replace('show', 'edit'));
                            $('#viewAppointmentModal').modal('show');
                        });
                    }
                },
                dateClick: function(info) {
                    $('input[name="appointment_datetime"]').val(info.dateStr + 'T12:00');
                    $('#createAppointmentModal').modal('show');
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                }
            });

            calendar.render();

            // Success message handling
            @if(session('success'))
                alert('{{ session('success') }}');
            @endif
        }
    });

//This is for the client section
     $(document).ready(function() {
            // Edit client button click handler
            $(document).on('click', '.edit-client-btn', function() {
                const clientId = $(this).data('id');
                const form = $('#editClientForm');
                
                // Set the form action with the client ID
                form.attr('action', '/clients/' + clientId);
                
                // Populate form fields
                $('#edit-name').val($(this).data('name'));
                $('#edit-email').val($(this).data('email'));
                $('#edit-phone').val($(this).data('phone'));
                $('#edit-address').val($(this).data('address'));
                $('#edit-contact-method').val($(this).data('preferred_contact_method'));
                $('#edit-notes').val($(this).data('notes'));
            });
        });





 // This is for product section
    document.querySelectorAll('.restockBtn').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-id');
            const productName = button.getAttribute('data-name');
            const form = document.getElementById('restockForm');
            
            // Set the form action with the product ID
            form.action = `/products/${productId}/restock`;
            
            // Populate product name field
            document.getElementById('restock-product-name').value = productName;
        });
    });



//this is for supplier
     document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', () => {
            const supplierId = button.getAttribute('data-id');
            const form = document.getElementById('editSupplierForm');
            
            // Set the form action with the supplier ID
            form.action = `/suppliers/${supplierId}`;
            
            // Populate form fields
            document.getElementById('edit-name').value = button.getAttribute('data-name');
            document.getElementById('edit-contact_info').value = button.getAttribute('data-contact_info');
        });
    });


//this is for pet
    document.addEventListener('DOMContentLoaded', function() {
        // Handle edit modal opening
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function() {
                const petId = this.getAttribute('data-id');
                const form = document.getElementById('editPetForm');
                form.action = form.action.replace(':id', petId);

                // Fill form fields
                document.getElementById('edit-client_id').value = this.getAttribute('data-client_id');
                document.getElementById('edit-name').value = this.getAttribute('data-name');
                document.getElementById('edit-species').value = this.getAttribute('data-species');
                document.getElementById('edit-breed').value = this.getAttribute('data-breed');
                document.getElementById('edit-gender').value = this.getAttribute('data-gender');
                document.getElementById('edit-birthdate').value = this.getAttribute('data-birthdate');
                document.getElementById('edit-weight_kg').value = this.getAttribute('data-weight_kg');
                document.getElementById('edit-microchip_number').value = this.getAttribute('data-microchip_number');
                document.getElementById('edit-vaccination_status').value = this.getAttribute('data-vaccination_status');
                document.getElementById('edit-allergies').value = this.getAttribute('data-allergies');
                document.getElementById('edit-notes').value = this.getAttribute('data-notes');

                // Handle image preview
                const imageUrl = this.getAttribute('data-image');
                const preview = document.getElementById('current-image-preview');
                const noImageText = document.getElementById('no-image-text');

                if (imageUrl) {
                    preview.src = imageUrl;
                    preview.style.display = 'block';
                    noImageText.style.display = 'none';
                } else {
                    preview.style.display = 'none';
                    noImageText.style.display = 'inline';
                }
            });
        });

        // Handle delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this pet?')) {
                    this.submit();
                }
            });
        });
    });

    // Delete confirmation
    $('.delete-form').on('submit', function(e) {
        if (!confirm('Are you sure you want to delete this pet?')) {
            e.preventDefault();
        }
    });



//this is for clinic
     document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const clinicId = button.getAttribute('data-id');
            const form = document.getElementById('editClinicForm');
            form.action = `/clinics/${clinicId}`;
            
            document.getElementById('editName').value = button.getAttribute('data-name');
            document.getElementById('editAddress').value = button.getAttribute('data-address');
            document.getElementById('editPhone').value = button.getAttribute('data-phone');
            document.getElementById('editEmail').value = button.getAttribute('data-email');
            
            // If you need to fetch additional data like branding_json, you would need an API endpoint
            // or include it in the data attributes
        });
    });



//this is for puchase order
  // Unified edit button handler for all sections
$(document).on('click', '[data-edit-type]', function() {
    const button = $(this);
    const editType = button.data('edit-type');
    
    switch(editType) {
        case 'purchase-order':
            const poId = button.data('id');
            let formAction = $('#editPOForm').attr('action');
            $('#editPOForm').attr('action', formAction.replace(':id', poId));
            
            $('#edit-supplier_id').val(button.data('supplier_id'));
            
            // Format dates correctly
            const orderDate = button.data('order_date') ? 
                new Date(button.data('order_date')).toISOString().split('T')[0] : '';
            const expectedDelivery = button.data('expected_delivery') ? 
                new Date(button.data('expected_delivery')).toISOString().split('T')[0] : '';
                
            $('#edit-order_date').val(orderDate);
            $('#edit-expected_delivery').val(expectedDelivery);
            
            $('#edit-status').val(button.data('status'));
            $('#edit-notes').val(button.data('notes') || '');
            break;
            
        // Other cases for different edit types can go here
    }
});



    // Product Edit Modal Population
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        const form = document.getElementById('editProductForm');
        
        // Update form action URL
        form.action = `/products/${productId}`;
        
        // Populate form fields
        document.getElementById('edit-name').value = this.getAttribute('data-name');
        document.getElementById('edit-category').value = this.getAttribute('data-category');
        document.getElementById('edit-quantity_in_stock').value = this.getAttribute('data-quantity_in_stock');
        document.getElementById('edit-reorder_threshold').value = this.getAttribute('data-reorder_threshold');
        document.getElementById('edit-price').value = this.getAttribute('data-price');
        document.getElementById('edit-supplier_id').value = this.getAttribute('data-supplier_id');
        document.getElementById('edit-batch_number').value = this.getAttribute('data-batch_number');
        
        // Handle expiry date (might be null)
        const expiryDate = this.getAttribute('data-expiry_date');
        document.getElementById('edit-expiry_date').value = expiryDate ? expiryDate : '';
    });
});



// Medical Record JS
// Medical Records JS
$(document).ready(function() {
    // Edit button handler
    $('.edit-btn').click(function() {
        const recordId = $(this).data('id');
        $('#editMedicalRecordForm').attr('action', '/medical-records/' + recordId);
        
        // Populate form fields
        $('#edit-pet_id').val($(this).data('pet_id'));
        $('#edit-vet_id').val($(this).data('vet_id'));
        $('#edit-visit_date').val($(this).data('visit_date'));
        $('#edit-subjective').val($(this).data('subjective'));
        $('#edit-objective').val($(this).data('objective'));
        $('#edit-assessment').val($(this).data('assessment'));
        $('#edit-plan').val($(this).data('plan'));
        $('#edit-custom_fields').val($(this).data('custom_fields'));
    });

    // Filter pets based on selected client (if you have a client filter)
    $('#client_id').change(function() {
        var clientId = $(this).val();
        $('#pet_id option').each(function() {
            var petClientId = $(this).data('client-id');
            if (petClientId == clientId || clientId === '') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $('#pet_id').val(''); // Reset pet selection
    });

    // Auto-show view modal if we're on a show page
    if (window.location.pathname.includes('/medical-records/') && 
        !window.location.pathname.includes('/edit')) {
        $('#viewMedicalRecordModal').modal('show');
    }
});
</script>