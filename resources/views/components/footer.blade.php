<!-- Footer -->


<!-- Required Scripts -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/datepick.js') }}"></script>



<script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
</script>
<script>
  $(document).ready(function () {
    const todayTable = new DataTable('#todayTable', {
      columnDefs: [
        { width: 150, targets: 0 },
        { width: 150, targets: 1 },
        { width: 120, targets: 2 },
        { width: 120, targets: 3 }
      ],
      responsive: true,
      searching: false,
      lengthChange: false,
      pageLength: 4,
      paging: true,
      info: false,

      drawCallback: function () {
        const info = this.api().page.info();
        $('.pater-today').text(`Page ${info.page + 1} of ${info.pages}`);
        $('.btn-previes').prop('disabled', info.page === 0);
        $('.btn-next').prop('disabled', info.page === info.pages - 1);
      }
    });

    $('.btn-next').on('click', function () {
      todayTable.page('next').draw('page');
    });

    $('.btn-previes').on('click', function () {
      todayTable.page('previous').draw('page');
    });

    todayTable.draw();
  });
</script>

<!-- subrata add -->
<script>
  $(document).ready(function () {
    const activeTable = new DataTable('#activeTable', {
      columnDefs: [
        { width: 150, targets: 0 },
        { width: 138, targets: 1 },
        { width: 138, targets: 2 },
        { width: 200, targets: 3 },
        { width: 138, targets: 4 },
        { width: 200, targets: 5 },
        { width: 138, targets: 6 },
      ],
      responsive: true,
      searching: false,
      lengthChange: false,
      pageLength: 4,
      paging: true,
      info: false,

      drawCallback: function () {
        const info = this.api().page.info();
        $('.pater').text(`Page ${info.page + 1} of ${info.pages}`);
        $('.btn-previes').prop('disabled', info.page === 0);
        $('.btn-next').prop('disabled', info.page === info.pages - 1);
      }
    });

    // Next button
    $('.btn-next').on('click', function () {
      activeTable.page('next').draw('page');
    });

    // Previous button
    $('.btn-previes').on('click', function () {
      activeTable.page('previous').draw('page');
    });

    // Trigger initial page info update
    activeTable.draw();
  });
</script>



<script>
  $(document).ready(function () {
    const cancelledTable = new DataTable('#cancelledTable', {
      columnDefs: [
        { width: 150, targets: 0 },
        { width: 138, targets: 1 },
        { width: 138, targets: 2 },
        { width: 200, targets: 3 },
        { width: 138, targets: 4 },
        { width: 200, targets: 5 },
        { width: 138, targets: 6 },
      ],
      responsive: true,
      searching: false,
      lengthChange: false,
      pageLength: 4,
      paging: true,
      info: false,

      drawCallback: function () {
        const info = this.api().page.info();
        $('.pater-cancel').text(`Page ${info.page + 1} of ${info.pages}`);
        $('.btn-previes').prop('disabled', info.page === 0);
        $('.btn-next').prop('disabled', info.page === info.pages - 1);
      }
    });

    // Next button
    $('.btn-next').on('click', function () {
      cancelledTable.page('next').draw('page');
    });

    // Previous button
    $('.btn-previes').on('click', function () {
      cancelledTable.page('previous').draw('page');
    });

    // Trigger initial page info update
    cancelledTable.draw();
  });
</script>


<script>
  $(document).ready(function () {
    const completedTable = new DataTable('#completedTable', {
      columnDefs: [
        { width: 150, targets: 0 },
        { width: 138, targets: 1 },
        { width: 138, targets: 2 },
        { width: 200, targets: 3 },
        { width: 138, targets: 4 },
        { width: 200, targets: 5 },
        { width: 138, targets: 6 },
      ],
      responsive: true,
      searching: false,
      lengthChange: false,
      pageLength: 4,
      paging: true,
      info: false,

      drawCallback: function () {
        const info = this.api().page.info();
        $('.pater-complete').text(`Page ${info.page + 1} of ${info.pages}`);
        $('.btn-previes').prop('disabled', info.page === 0);
        $('.btn-next').prop('disabled', info.page === info.pages - 1);
      }
    });

    // Next button
    $('.btn-next').on('click', function () {
      completedTable.page('next').draw('page');
    });

    // Previous button
    $('.btn-previes').on('click', function () {
      completedTable.page('previous').draw('page');
    });

    // Trigger initial page info update
    completedTable.draw();
  });
</script>





<script>
   $(document).ready(function(){
      new DataTable('#example-new', {
          responsive: true,
          searching: false,
          lengthChange: false,
          pageLength: 5,
      });
    });
</script>

<script>
  $(document).ready(function () {
    const exampledirectory1 = new DataTable('#exampledirectory1', {
      columnDefs: [
        { width: 173, targets: 0 },
            { width: 173, targets: 1 },
            { width: 173, targets: 2 },
            { width: 173, targets: 3 },
            { width: 173, targets: 4 },
            { width: 173, targets: 5 },
            { width: 173, targets: 6 },
      ],
      responsive: true,
      searching: false,
      lengthChange: false,
      pageLength: 3,
      paging: true,
      info: false,

      drawCallback: function () {
        const info = this.api().page.info();
        $('.pater').text(`Page ${info.page + 1} of ${info.pages}`);
        $('.btn-previes').prop('disabled', info.page === 0);
        $('.btn-next').prop('disabled', info.page === info.pages - 1);
      }
    });

    $('.btn-next').on('click', function () {
      exampledirectory1.page('next').draw('page');
    });

    $('.btn-previes').on('click', function () {
      exampledirectory1.page('previous').draw('page');
    });

    exampledirectory1.draw();
  });
</script>

<script>
  $(document).ready(function () {
    const exampledirectory1 = new DataTable('#exampleoverdue', {
      columnDefs: [
        { width: 173, targets: 0 },
            { width: 173, targets: 1 },
            { width: 173, targets: 2 },
            { width: 173, targets: 3 },
            { width: 173, targets: 4 },
            { width: 173, targets: 5 },
      ],
      responsive: true,
      searching: false,
      lengthChange: false,
      pageLength: 3,
      paging: true,
      info: false,

      drawCallback: function () {
        const info = this.api().page.info();
        $('.pater').text(`Page ${info.page + 1} of ${info.pages}`);
        $('.btn-previes').prop('disabled', info.page === 0);
        $('.btn-next').prop('disabled', info.page === info.pages - 1);
      }
    });

    $('.btn-next').on('click', function () {
      exampledirectory1.page('next').draw('page');
    });

    $('.btn-previes').on('click', function () {
      exampledirectory1.page('previous').draw('page');
    });

    exampledirectory1.draw();
  });
</script>
<script>
  $(document).ready(function () {
    const inventoryTable = $('#inventoryTable').DataTable({
      columnDefs: [
        { width: 200, targets: 0 },
        { width: 120, targets: 1 },
        { width: 120, targets: 2 },
        { width: 120, targets: 3 },
        { width: 120, targets: 4 },
        { width: 100, targets: 5 }
      ],
      responsive: true,
      searching: false,
      lengthChange: false,
      pageLength: 4,
      paging: true,
      info: false,

      drawCallback: function () {
        const info = this.api().page.info();
        $('.pater-inventory').text(`Page ${info.page + 1} of ${info.pages}`);
        $('.btn-previes').prop('disabled', info.page === 0);
        $('.btn-next').prop('disabled', info.page === info.pages - 1);
      }
    });

    $('.btn-next').on('click', function () {
      inventoryTable.page('next').draw('page');
    });

    $('.btn-previes').on('click', function () {
      inventoryTable.page('previous').draw('page');
    });

    // Initial page update
    const initialInfo = inventoryTable.page.info();
    $('.pater-inventory').text(`Page ${initialInfo.page + 1} of ${initialInfo.pages}`);
    $('.btn-previes').prop('disabled', initialInfo.page === 0);
    $('.btn-next').prop('disabled', initialInfo.page === initialInfo.pages - 1);
  });
</script>



<script>
  $(document).ready(function () {
    const examplepetdirectory = new DataTable('#examplepetdirectory', {
      columnDefs: [
       { width: 275, targets: 0 },
            { width: 255, targets: 1 },
            { width: 255, targets: 2 },
            { width: 235, targets: 3 },
            { width: 138, targets: 4 },
      ],
      responsive: true,
      searching: false,
      lengthChange: false,
      pageLength: 4,
      paging: true,
      info: false,

      drawCallback: function () {
        const info = this.api().page.info();
        $('.pater').text(`Page ${info.page + 1} of ${info.pages}`);
        $('.btn-previes').prop('disabled', info.page === 0);
        $('.btn-next').prop('disabled', info.page === info.pages - 1);
      }
    });

    $('.btn-next').on('click', function () {
      examplepetdirectory.page('next').draw('page');
    });

    $('.btn-previes').on('click', function () {
      examplepetdirectory.page('previous').draw('page');
    });

    examplepetdirectory.draw();
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.11.0/main.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>

<script>
$(document).on('blur', 'input[name="owners_name"]', function() {
    var name = $(this).val().trim();

    if (name === '') return;

    $.ajax({
        url: '/clients/fetch-by-name',
        method: 'GET',
        data: { name: name },
        success: function(response) {
            if (response.success && response.data) {
                const client = response.data;

                $('input[name="email"]').val(client.email ?? '');
                $('input[name="phone"]').val(client.phone ?? '');
                $('textarea[name="address"]').val(client.address ?? '');
                $('input[name="city"]').val(client.city ?? '');
                $('input[name="state"]').val(client.state ?? '');
                $('input[name="zipcode"]').val(client.zipcode ?? '');
                $('select[name="gender"]').val(client.gender ?? '');
                $('input[name="dateofbirth"]').val(client.dateofbirth ?? '');
            } else {
                console.warn('Client not found.');
            }
        },
        error: function(xhr) {
            console.error('AJAX error:', xhr.responseText);
        }
    });
});
</script>
<!--when pet id is given pet and owner name will autofill-->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const petIdInput = document.getElementById('pet_id_input');
    const clientSelect = document.getElementById('client_id');
    const petSelect = document.getElementById('pet_id');

    petIdInput.addEventListener('blur', function () {
        const petId = this.value.trim();

        if (!petId) return;

        fetch(`https://ascinate.in/projects/pawmetric/appointments/pets/${petId}/info`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Update client select
                if (data.owner_id) {
                    clientSelect.value = data.owner_id;
                    clientSelect.dispatchEvent(new Event('change'));
                }

                // Wait a moment before setting pet (due to async load)
                setTimeout(() => {
                    petSelect.disabled = false;
                    petSelect.value = petId;
                }, 500);
            })
            .catch(err => {
                console.error('Error fetching pet info:', err);
                alert('Failed to fetch pet info');
            });
    });
});
</script>


<!--filter pet according to owner during store-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const clientSelect = document.getElementById('client_id');
        const petSelect = document.getElementById('pet_id');

        clientSelect.addEventListener('change', function () {
            const clientId = this.value;

            // Reset pet dropdown
            petSelect.innerHTML = '<option value="">Loading pets...</option>';
            petSelect.disabled = true;

            if (clientId) {
                fetch(`appointments/client/${clientId}/pets`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(pets => {
                        if (pets.length > 0) {
                            petSelect.innerHTML = '<option value="">Select Pet</option>';
                            pets.forEach(pet => {
                                const option = document.createElement('option');
                                option.value = pet.id;
                                option.textContent = `${pet.name} (${pet.species})`;
                                petSelect.appendChild(option);
                            });
                            petSelect.disabled = false;
                        } else {
                            petSelect.innerHTML = '<option value="">No pets found for this client</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching pets:', error);
                        petSelect.innerHTML = '<option value="">Error loading pets</option>';
                    });
            } else {
                petSelect.innerHTML = '<option value="">Select Client First</option>';
                petSelect.disabled = true;
            }
        });
    });
</script>

<!-- Appointment Modal Prefill Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('edit-appointment-id').value = this.getAttribute('data-id');
                document.getElementById('edit-client_id').value = this.getAttribute('data-client_id');
                document.getElementById('edit-pet_id').value = this.getAttribute('data-pet_id');
                document.getElementById('edit-clinic_id').value = this.getAttribute('data-clinic_id');
                document.getElementById('edit-vet_id').value = this.getAttribute('data-vet_id');
                document.getElementById('edit-appointment_datetime').value = this.getAttribute('data-appointment_datetime');
                document.getElementById('edit-duration_minutes').value = this.getAttribute('data-duration_minutes');
                document.getElementById('edit-status').value = this.getAttribute('data-status');
                document.getElementById('edit-notes').value = this.getAttribute('data-notes');

                // Filter pet options based on client
                const clientId = this.getAttribute('data-client_id');
                const petSelect = document.getElementById('edit-pet_id');
                [...petSelect.options].forEach(option => {
                    const petClientId = option.getAttribute('data-client-id');
                    option.style.display = (petClientId === clientId) ? 'block' : 'none';
                });
            });
        });
    });
</script>
<!--vet filter-->
<script>
document.getElementById('vet_filter').addEventListener('change', function() {
    const vetId = this.value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (!vetId || row.querySelector('td:nth-child(4)').textContent.includes(
            document.querySelector(`#vet_filter option[value="${vetId}"]`).textContent
        )) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<!-- Client Management Scripts -->
<script>
   document.addEventListener('DOMContentLoaded', function () {
    // Initialize DataTable
    $('#clientsTable').DataTable({
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [5, 6] } // Disable sorting for Actions column
        ]
    });

    // Client Modal Prefill Script
    document.querySelectorAll('.edit-client-btn').forEach(button => {
        button.addEventListener('click', function () {
            const clientId = this.getAttribute('data-id');
            const clientName = this.getAttribute('data-name');
            const clientEmail = this.getAttribute('data-email');
            const clientPhone = this.getAttribute('data-phone');
            const clientAddress = this.getAttribute('data-address') || '';
            const contactMethod = this.getAttribute('data-preferred_contact_method');
            const clientNotes = this.getAttribute('data-notes') || '';

            document.getElementById('edit-client-id').value = clientId;
            document.getElementById('edit-name').value = clientName;
            document.getElementById('edit-email').value = clientEmail;
            document.getElementById('edit-phone').value = clientPhone;
            document.getElementById('edit-address').value = clientAddress;
            document.getElementById('edit-contact-method').value = contactMethod;
            document.getElementById('edit-notes').value = clientNotes;
        });
    });

    // Delete confirmation
    document.querySelectorAll('.delete-client-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this client and all associated data?')) {
                e.preventDefault();
            }
        });
    });

    // File input preview for create modal
    const createFileInput = document.querySelector('#createClientModal input[type="file"]');
    if (createFileInput) {
        createFileInput.addEventListener('change', function() {
            const files = this.files;
            const fileNames = Array.from(files).map(file => file.name).join(', ');
            const label = this.nextElementSibling;
            if (files.length > 0) {
                label.textContent = `${files.length} file(s) selected: ${fileNames}`;
                label.classList.add('text-primary');
            } else {
                label.textContent = 'You can upload multiple documents (PDF, JPG, PNG, DOC)';
                label.classList.remove('text-primary');
            }
        });
    }

    // File input preview for edit modal
    const editFileInput = document.querySelector('#editClientModal input[type="file"]');
    if (editFileInput) {
        editFileInput.addEventListener('change', function() {
            const files = this.files;
            const fileNames = Array.from(files).map(file => file.name).join(', ');
            const label = this.nextElementSibling;
            if (files.length > 0) {
                label.textContent = `${files.length} additional file(s) selected: ${fileNames}`;
                label.classList.add('text-primary');
            } else {
                label.textContent = 'You can upload multiple documents (PDF, JPG, PNG, DOC)';
                label.classList.remove('text-primary');
            }
        });
    }
});

</script>

<!--Supplier model edit script-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.editSupplierBtn');
        const form = document.getElementById('editSupplierForm');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const contactInfo = this.dataset.contact_info;

                // Fill the form fields
                document.getElementById('edit-name').value = name;
                document.getElementById('edit-contact_info').value = contactInfo;

                // Set the form action URL
                const action = form.getAttribute('action').replace(':id', id);
                form.setAttribute('action', action);
            });
        });
    });
</script>

<!-- Medical Record Prefill Script -->
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#medicalRecordsTable').DataTable({
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [5] } // Disable sorting for Actions column
            ]
        });

        // Edit modal prefilling
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const form = document.getElementById('editMedicalRecordForm');
                const recordId = this.getAttribute('data-id');
                
                // Update form action URL
                form.action = form.action.replace(':id', recordId);
                document.getElementById('edit-id').value = recordId;
                
                // Fill form fields
                document.getElementById('edit-pet_id').value = this.getAttribute('data-pet_id');
                document.getElementById('edit-vet_id').value = this.getAttribute('data-vet_id');
                document.getElementById('edit-visit_date').value = this.getAttribute('data-visit_date');
                document.getElementById('edit-subjective').value = this.getAttribute('data-subjective');
                document.getElementById('edit-objective').value = this.getAttribute('data-objective');
                document.getElementById('edit-assessment').value = this.getAttribute('data-assessment');
                document.getElementById('edit-plan').value = this.getAttribute('data-plan');
                document.getElementById('edit-custom_fields').value = this.getAttribute('data-custom_fields');

                // Load attachments via AJAX
                fetch(`https://ascinate.in/projects/pawmetric/medical-records/${recordId}/attachments`)
                    .then(response => response.json())
                    .then(attachments => {
                        const container = document.getElementById('current-attachments-container');
                        container.innerHTML = '';

                        if (attachments.length === 0) {
                            container.innerHTML = '<p class="text-muted mb-2">No attachments found</p>';
                            return;
                        }

                        const listGroup = document.createElement('div');
                        listGroup.className = 'list-group';

                        attachments.forEach(attachment => {
                            const fileName = attachment.file_path.split('/').pop();
                            const fileIcon = getFileIcon(attachment.file_type);

                            const item = document.createElement('div');
                            item.className = 'list-group-item d-flex justify-content-between align-items-center';

                            const fileInfo = document.createElement('div');
                            fileInfo.innerHTML = `
                                <i class="fas fa-file-${fileIcon} me-2"></i>
                                ${fileName}
                                <small class="text-muted ms-2">${attachment.file_type.toUpperCase()}</small>
                            `;

                            const checkbox = document.createElement('div');
                            checkbox.className = 'form-check';
                            checkbox.innerHTML = `
                                <input class="form-check-input" type="checkbox" name="delete_attachments[]" 
                                    value="${attachment.id}" id="delete-attachment-${attachment.id}">
                                <label class="form-check-label" for="delete-attachment-${attachment.id}">
                                    Delete
                                </label>
                            `;

                            const downloadLink = document.createElement('a');
                            downloadLink.href = `/assets/uploads/medical_docs/${fileName}`;
                            downloadLink.className = 'btn btn-sm btn-outline-primary';
                            downloadLink.target = '_blank';
                            downloadLink.innerHTML = '<i class="fas fa-download"></i>';

                            item.appendChild(fileInfo);
                            item.appendChild(downloadLink);
                            item.appendChild(checkbox);
                            listGroup.appendChild(item);
                        });

                        container.appendChild(listGroup);
                    })
                    .catch(error => {
                        console.error('Error fetching attachments:', error);
                    });
            });
        });

        function getFileIcon(fileType) {
            const type = fileType.toLowerCase();
            if (type === 'pdf') return 'pdf';
            if (['jpg', 'jpeg', 'png', 'gif'].includes(type)) return 'image';
            if (['doc', 'docx'].includes(type)) return 'word';
            return 'alt';
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function () {
      document.getElementById('edit-clinic-id').value = this.getAttribute('data-id');
      document.getElementById('edit-name').value = this.getAttribute('data-name');
      document.getElementById('edit-phone').value = this.getAttribute('data-phone');
      document.getElementById('edit-email').value = this.getAttribute('data-email');
      document.getElementById('edit-address').value = this.getAttribute('data-address');
      document.getElementById('edit-branding_json').value = this.getAttribute('data-branding_json');
    });
  });
});
</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.edit-product-btn').forEach(button => {
      button.addEventListener('click', function () {
        document.getElementById('edit-id').value = this.getAttribute('data-id');
        document.getElementById('edit-name').value = this.getAttribute('data-name');
        document.getElementById('edit-category').value = this.getAttribute('data-category');
        document.getElementById('edit-quantity_in_stock').value = this.getAttribute('data-quantity_in_stock');
        document.getElementById('edit-reorder_threshold').value = this.getAttribute('data-reorder_threshold');
        document.getElementById('edit-price').value = this.getAttribute('data-price');
        document.getElementById('edit-batch_number').value = this.getAttribute('data-batch_number');
        document.getElementById('edit-expiry_date').value = this.getAttribute('data-expiry_date');
        document.getElementById('edit-supplier_id').value = this.getAttribute('data-supplier_id');
      });
    });
  });
</script>
<!-- Appointment Modal Prefill Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('edit-appointment-id').value = this.getAttribute('data-id');
                document.getElementById('edit-client_id').value = this.getAttribute('data-client_id');
                document.getElementById('edit-pet_id').value = this.getAttribute('data-pet_id');
                document.getElementById('edit-clinic_id').value = this.getAttribute('data-clinic_id');
                document.getElementById('edit-vet_id').value = this.getAttribute('data-vet_id');
                document.getElementById('edit-appointment_datetime').value = this.getAttribute('data-appointment_datetime');
                document.getElementById('edit-duration_minutes').value = this.getAttribute('data-duration_minutes');
                document.getElementById('edit-status').value = this.getAttribute('data-status');
                document.getElementById('edit-notes').value = this.getAttribute('data-notes');

                // Filter pet options based on client
                const clientId = this.getAttribute('data-client_id');
                const petSelect = document.getElementById('edit-pet_id');
                [...petSelect.options].forEach(option => {
                    const petClientId = option.getAttribute('data-client-id');
                    option.style.display = (petClientId === clientId) ? 'block' : 'none';
                });
            });
        });
    });
</script>


  <!--settings page-->
    <script>
    const addButton = document.getElementById('settings-services-add');
    const inputDiv = document.getElementById('service-input-container');

    addButton.addEventListener('click', () => {
        inputDiv.style.display = 'block';
    });

    const addServiceBtn = document.getElementById('add-service-btn');
    const serviceInput = document.getElementById('service-input');
    const serviceContainer = document.getElementById('service-container');

    addServiceBtn.addEventListener('click', () => {
        const inputValue = serviceInput.value.trim();

        if (inputValue === "") {
            alert("Please enter a service name");
            return;
        }

        const newDiv = document.createElement('div');
        newDiv.className = "settings-vac d-flex align-items-center justify-content-between vac-rad";
        newDiv.innerHTML = `
      <p>${inputValue}</p>
      <div class="my-0 d-flex align-items-center justify-content-between wten">
        <button class="btn-delete-edit m-0">
          <img src="./images/idelete.svg" alt="">
        </button>
        <button class="btn-delete-edit m-0">
          <img src="./images/iedit.svg" alt="">
        </button>
      </div>
    `;

        // Find first existing settings-vac div
        const firstVac = serviceContainer.querySelector('.settings-vac');

        if (firstVac) {
            serviceContainer.insertBefore(newDiv, firstVac); // Insert at the top
        } else {
            serviceContainer.appendChild(newDiv); // If none exist, append normally
        }

        serviceInput.value = ""; // Clear input
        inputDiv.style.display = 'none'; // Optional: Hide input again after adding
    });





    // Show input when Add button clicked
    const medAddBtn = document.getElementById('medication-add-btn');
    const medInputDiv = document.getElementById('medication-input-container');
    const medInput = document.getElementById('medication-input');
    const medSubmitBtn = document.getElementById('add-medication-btn');

    // The container that holds all medication blocks
    const medicationCard = medAddBtn.closest('.settings-card');

    medAddBtn.addEventListener('click', () => {
        medInputDiv.style.display = 'block';
    });

    medSubmitBtn.addEventListener('click', () => {
        const value = medInput.value.trim();
        if (value === "") {
            alert("Please enter a medication name");
            return;
        }

        const newMedDiv = document.createElement('div');
        newMedDiv.className = "settings-vac d-flex align-items-center justify-content-between vac-rad";
        newMedDiv.innerHTML = `
      <p>${value}</p>
      <div class="my-0 d-flex align-items-center justify-content-between wten">
        <button class="btn-delete-edit m-0">
          <img src="./images/idelete.svg" alt="">
        </button>
        <button class="btn-delete-edit m-0">
          <img src="./images/iedit.svg" alt="">
        </button>
      </div>
    `;

        // Insert before the first .settings-vac in the medication section
        const firstMedVac = medicationCard.querySelector('.settings-vac');
        if (firstMedVac) {
            medicationCard.insertBefore(newMedDiv, firstMedVac);
        } else {
            medicationCard.appendChild(newMedDiv);
        }

        medInput.value = "";
        medInputDiv.style.display = 'none'; // hide again after adding
    });
    </script>


<script>
$(document).ready(function() {
    const examplepetreminder= new DataTable('#examplepetreminder', {
        columnDefs: [{
                width: 400,
                targets: 0
            },
            {
                width: 160,
                targets: 1
            },
            {
                width: 160,
                targets: 2
            },
            {
                width: 160,
                targets: 3
            },
            {
                width: 160,
                targets: 4
            },
            {
                width: 188,
                targets: 5
            },
        ],
        responsive: true,
        searching: false,
        lengthChange: false,
        pageLength: 4,
        paging: true,
        info: false,

        drawCallback: function() {
            const info = this.api().page.info();
            $('.pater').text(`Page ${info.page + 1} of ${info.pages}`);
            $('.btn-previes').prop('disabled', info.page === 0);
            $('.btn-next').prop('disabled', info.page === info.pages - 1);
        }
    });

    $('.btn-next').on('click', function() {
        examplepetreminder.page('next').draw('page');
    });

    $('.btn-previes').on('click', function() {
        examplepetreminder.page('previous').draw('page');
    });

    examplepetreminder.draw();
});
</script>


<!--dataanalytics-->
  <!-- AmCharts CDN -->
 <!-- AmCharts CDN -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <script>
        am5.ready(function () {
            var root = am5.Root.new("chartdiv");

            root.setThemes([am5themes_Animated.new(root)]);

            var chart = root.container.children.push(
                am5xy.XYChart.new(root, {
                    panX: false,
                    panY: false,
                    layout: root.verticalLayout
                })
            );

            // X Axis
            var xAxis = chart.xAxes.push(
                am5xy.CategoryAxis.new(root, {
                    categoryField: "month",
                    renderer: am5xy.AxisRendererX.new(root, {
                        minGridDistance: 30
                    })
                })
            );

            // Y Axis
            var yAxis = chart.yAxes.push(
                am5xy.ValueAxis.new(root, {
                    renderer: am5xy.AxisRendererY.new(root, {})
                })
            );

            // Series
            var series = chart.series.push(
                am5xy.LineSeries.new(root, {
                    name: "Appointments",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "appointments",
                    categoryXField: "month",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueY} appointments\\n{categoryX}"
                    }),
                    stroke: am5.color(0x3e3a88),
                    fill: am5.color(0x3e3a88)
                })
            );

            series.strokes.template.setAll({
                strokeWidth: 2
            });

            series.fills.template.setAll({
                fillOpacity: 0.2,
                visible: true
            });

            // Cursor
            chart.set("cursor", am5xy.XYCursor.new(root, {
                behavior: "none",
                xAxis: xAxis
            }));

            // Data
            const data = [
                { month: "Jan", appointments: 10 },
                { month: "Feb", appointments: 12 },
                { month: "Mar", appointments: 13 },
                { month: "Apr", appointments: 16 },
                { month: "May", appointments: 20 },
                { month: "Jun", appointments: 25 },
                { month: "Jul", appointments: 19 },
                { month: "Aug", appointments: 21 },
                { month: "Sep", appointments: 20 },
                { month: "Oct", appointments: 23 },
                { month: "Nov", appointments: 26 },
                { month: "Dec", appointments: 30 }
            ];

            xAxis.data.setAll(data);
            series.data.setAll(data);

            series.appear(1000);
            chart.appear(1000, 100);
        });
    </script>
