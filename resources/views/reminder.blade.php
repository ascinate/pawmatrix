<x-header />

<body>
    <main class="float-start w-100">
        <x-sidebar />

        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-12">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12 ">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="headingh1">Reminder Hub</h2>
                                <button class="new-pet" data-bs-toggle="modal" data-bs-target="#createReminderModal">
                                    <span class="font-w">+</span>
                                    Create new Reminder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="col-lg-12 mt-3">
                                <div class="comon-li p-0 d-inline-block w-100">
                                    @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                    @endif

                                    <div class="taosy01 w-100 thead-bt">
                                        <table id="examplepetreminder" class="table table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Reminder</th>
                                                    <th>Assign</th>
                                                    <th>
                                                        <img src="./images/flag.svg" alt="">
                                                        Priority
                                                    </th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody-pad">
                                                @foreach($reminders as $reminder)
                                                <tr>
                                                    <td>{{ $reminder->title }}</td>
                                                    <td>{{ $reminder->assignedUser->name }}</td>
                                                    <td>
                                                        @if($reminder->priority == 'low')
                                                        <p
                                                            class="low-sts d-flex align-items-center justify-content-center">
                                                            <img src="./images/flag-g.svg" alt="">
                                                            <span class="low-text">Low</span>
                                                        </p>
                                                        @elseif($reminder->priority == 'medium')
                                                        <p
                                                            class="medium-sts d-flex align-items-center justify-content-center">
                                                            <img src="./images/flag-y.svg" alt="">
                                                            <span class="medium-text">Medium</span>
                                                        </p>
                                                        @else
                                                        <p
                                                            class="higt-sts btn d-flex align-items-center justify-content-center">
                                                            <img src="./images/flag-r.svg" alt="">
                                                            <span class="higt-text">High</span>
                                                        </p>
                                                        @endif
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($reminder->due_date)->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        <form
                                                            action="{{ route('reminders.update-status', $reminder->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <select name="status" class="form-select"
                                                                onchange="this.form.submit()"
                                                                style="border: none; background: transparent; box-shadow: none;">
                                                                <option value="todo"
                                                                    {{ $reminder->status == 'todo' ? 'selected' : '' }}>
                                                                    To Do</option>
                                                                <option value="working"
                                                                    {{ $reminder->status == 'working' ? 'selected' : '' }}>
                                                                    Working On</option>
                                                                <option value="completed"
                                                                    {{ $reminder->status == 'completed' ? 'selected' : '' }}>
                                                                    Completed</option>
                                                            </select>
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <div
                                                            class="my-0 d-flex align-items-center justify-content-evenly pe-3">
                                                            <form
                                                                action="{{ route('reminders.destroy', $reminder->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-delete-edit"
                                                                    onclick="return confirm('Are you sure?')">
                                                                    <img src="./images/idelete.svg" alt="Delete">
                                                                </button>
                                                            </form>
                                                            <button class="btn-delete-edit edit-reminder"
                                                                data-id="{{ $reminder->id }}"
                                                                data-title="{{ $reminder->title }}"
                                                                data-description="{{ $reminder->description }}"
                                                                data-assigned_to="{{ $reminder->assigned_to }}"
                                                                data-priority="{{ $reminder->priority }}"
                                                                data-due_date="{{ $reminder->due_date }}">
                                                                <img src="./images/iedit.svg" alt="Edit">
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Create Reminder Modal -->
    <div class="modal fade crm-modalsd01-forms" id="createReminderModal" tabindex="-1"
        aria-labelledby="createReminderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg create-reminder-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createReminderModalLabel">Create Reminder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('reminders.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="crm-form-modal">
                            <div class="row gy-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Reminder Name</label>
                                        <input type="text" name="title" class="form-control" placeholder="Reminder Name"
                                            required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control reminder"
                                            rows="4" cols="50" placeholder="Enter reminder description"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Assignee</label>
                                        <select name="assigned_to" class="form-select" required>
                                            <option value="">Select Assignee</option>
                                            @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Priority</label>
                                        <select name="priority" class="form-select" required>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Due Date</label>
                                        <input type="date" name="due_date" class="form-control datepicker" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pe-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Reminder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Reminder Modal -->
    <div class="modal fade crm-modalsd01-forms" id="editReminderModal" tabindex="-1"
        aria-labelledby="editReminderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg create-reminder-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editReminderModalLabel">Edit Reminder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editReminderForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="crm-form-modal">
                            <div class="row gy-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Reminder Name</label>
                                        <input type="text" name="title" id="edit_title" class="form-control"
                                            placeholder="Reminder Name" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="edit_description" class="form-label">Description</label>
                                        <textarea name="description" id="edit_description" class="form-control reminder"
                                            rows="4" cols="50" placeholder="Enter reminder description"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Assignee</label>
                                        <select name="assigned_to" id="edit_assigned_to" class="form-select" required>
                                            <option value="">Select Assignee</option>
                                            @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Priority</label>
                                        <select name="priority" id="edit_priority" class="form-select" required>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Due Date</label>
                                        <input type="date" name="due_date" id="edit_due_date"
                                            class="form-control datepicker" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pe-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Reminder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-footer />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
  
    $(document).ready(function () {
        // ✅ Initialize DataTable
        new DataTable('#examplepetreminder', {
            responsive: true,
            searching: false,
            lengthChange: false
        });

        // ✅ Edit reminder modal handler
        $('.edit-reminder').click(function () {
            const reminderId = $(this).data('id');
            const title = $(this).data('title');
            const description = $(this).data('description');
            const assigned_to = $(this).data('assigned_to');
            const priority = $(this).data('priority');
            const due_date = $(this).data('due_date');

            $('#edit_title').val(title);
            $('#edit_description').val(description);
            $('#edit_assigned_to').val(assigned_to);
            $('#edit_priority').val(priority);
            $('#edit_due_date').val(due_date);

            $('#editReminderForm').attr('action', "/reminders/" + reminderId);
            $('#editReminderModal').modal('show');
        });
    });

    </script>
</body>

</html>