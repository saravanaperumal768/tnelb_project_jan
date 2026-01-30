@include('admincms.include.top')
@include('admincms.include.header')
@include('admincms.include.navbar')


<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="middle-content container-xxl p-0">
            <!--  BEGIN BREADCRUMBS  -->
            <div class="secondary-nav">
                <div class="breadcrumbs-container" data-page-heading="Analytics">
                    <header class="header navbar navbar-expand-sm">
                        <a href="#" class="btn-toggle sidebarCollapse" data-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </a>
                        <div class="d-flex breadcrumb-content">
                            <div class="page-header">

                                <div class="page-title">
                                </div>

                                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#"></a></li>

                                    </ol>
                                </nav>

                            </div>
                        </div>

                    </header>
                </div>
            </div>
            <!--  END BREADCRUMBS  -->

            <div class="row scrumboard pt-3" id="cancel-row">
                <div class="col-lg-12 layout-spacing">
                    <div class="row">
                        <div class="col-lg-12">
                            <div data-section="s-new" class="task-list-container" data-connect="sorting">
                                <div class="connect-sorting">
                                    <div class="task-container-header">
                                        <h6 class="s-heading">{{ strtoupper($records->first()->page_name ?? 'About') }} PAGE</h6>
                                        <div>
                                            <button type="button" class="btn btn-primary mb-2 me-4 _effect--ripple waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#languageSelectModal">
                                                <i class="fa fa-plus"></i>&nbsp; Add New
                                            </button>

                                            <!-- Language Selection Modal -->
                                            
                                            <div class="modal fade" id="languageSelectModal" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5>Select Language</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal">X</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <button type="button" class="btn btn-success" id="openEnglishForm">English</button>
                                                            <button type="button" class="btn btn-danger" id="openTamilForm">Tamil</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- English Content Modal -->
                                            
                                            <div class="modal fade" id="inputFormModal" tabindex="-1" role="dialog" aria-labelledby="inputFormModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" id="inputFormModalLabel">
                                                            <h5 class="modal-title">Add English Content</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">X</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="backend/about/update_aboutcontent.php" method="POST">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="task-badge d-flex">
                                                                            <textarea id="add-tasks" placeholder="Task Text" class="form-control richcontent" name="content_english"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <button type="submit" class="btn btn-success float-right">Add</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tamil Content Modal -->
                                        
                                        </div>
                                    </div>
                                </div>

                                <div class="connect-sorting-content" data-sortable="true">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#english-tab">English</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tamil-tab">Tamil</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content mt-3">
                                        <!-- English Tab -->
                                        <div class="tab-pane fade show active" id="english-tab">
                                            @foreach($records as $record)
                                            <div data-draggable="true" class="card img-task">
                                                <div class="card-body">
                                                    <div class="task-header mb-4 table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center" width="5%">Image</th>
                                                                    <th class="text-center" width="30%">Content</th>
                                                                    <th class="text-center" width="5%">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <img class="img-thumbnail" src="{{ asset('uploads/about/' . $record->about_image) }}" width="100" />
                                                                    </td>
                                                                    <td class="text-justify" style="word-wrap: break-word; max-width: 150px;">
                                                                        <h4>
                                                                            @foreach(array_chunk(explode(' ', e($record->english_content)), 12) as $line)
                                                                            {{ implode(' ', $line) }}<br>
                                                                            @endforeach
                                                                        </h4>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="d-flex justify-content-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                          width="24"
                                                                                          height="24"
                                                                                          viewBox="0 0 24 24"
                                                                                          fill="none"
                                                                                          stroke="#4361ee"
                                                                                          stroke-width="2"
                                                                                          stroke-linecap="round"
                                                                                          stroke-linejoin="round"
                                                                                          class="feather feather-edit-2 s-task-edit me-2"
                                                                                          data-bs-toggle="modal"
                                                                                          data-bs-target="#addTaskModal"
                                                                                         data-id="{{ $record->id }}"
                                                                                         data-content="{{ e($record->english_content) }}">
                                                                                          <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                      </svg>

                                                                                      <!-- Delete Icon -->
                                                                                      <svg xmlns="http://www.w3.org/2000/svg"
                                                                                          width="24"
                                                                                          height="24"
                                                                                          viewBox="0 0 24 24"
                                                                                          fill="none"
                                                                                          stroke="#4361ee"
                                                                                          stroke-width="2"
                                                                                          stroke-linecap="round"
                                                                                          stroke-linejoin="round"
                                                                                          class="feather feather-trash-2 s-task-delete"
                                                                                          data-bs-toggle="modal"
                                                                                          data-bs-target="#deleteConformation"
                                                                                          onclick="setTaskId({{  $record->id }})">
                                                                                          <polyline points="3 6 5 6 21 6"></polyline>
                                                                                          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                          <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                                          <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                                      </svg>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <!-- Tamil Tab -->
                                        <div class="tab-pane fade" id="tamil-tab">
                                            @foreach($records as $record)
                                            <div data-draggable="true" class="card img-task">
                                                <div class="card-body">
                                                    <div class="task-header mb-4 table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center" width="5%">Image</th>
                                                                    <th class="text-center" width="30%">Content [Tamil]</th>
                                                                    <th class="text-center" width="5%">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <img class="img-thumbnail" src="{{ asset('uploads/about/' . $record->about_image) }}" width="100" />
                                                                    </td>
                                                                    <td class="text-justify" style="word-wrap: break-word; max-width: 150px;">
                                                                        <h4 class="text-center">
                                                                            @foreach(array_chunk(explode(' ', e($record->tamil_content)), 12) as $line)
                                                                            {{ implode(' ', $line) }}<br>
                                                                            @endforeach
                                                                        </h4>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="d-flex justify-content-center">
                                                                              <!-- Edit Icon -->
                                                                                     <svg xmlns="http://www.w3.org/2000/svg"
                                                                                          width="24"
                                                                                          height="24"
                                                                                          viewBox="0 0 24 24"
                                                                                          fill="none"
                                                                                          stroke="#4361ee"
                                                                                          stroke-width="2"
                                                                                          stroke-linecap="round"
                                                                                          stroke-linejoin="round"
                                                                                          class="feather feather-edit-2 s-task-edit me-2"
                                                                                          data-bs-toggle="modal"
                                                                                          data-bs-target="#addTaskModal"
                                                                                         data-id="{{ $record->id }}"
                                                                                         data-content="{{ e($record->tamil_content) }}">
                                                                                          <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                                      </svg>

                                                                                      <!-- Delete Icon -->
                                                                                      <svg xmlns="http://www.w3.org/2000/svg"
                                                                                          width="24"
                                                                                          height="24"
                                                                                          viewBox="0 0 24 24"
                                                                                          fill="none"
                                                                                          stroke="#4361ee"
                                                                                          stroke-width="2"
                                                                                          stroke-linecap="round"
                                                                                          stroke-linejoin="round"
                                                                                          class="feather feather-trash-2 s-task-delete"
                                                                                          data-bs-toggle="modal"
                                                                                          data-bs-target="#deleteConformation"
                                                                                          onclick="setTaskId({{  $record->id }})">
                                                                                          <polyline points="3 6 5 6 21 6"></polyline>
                                                                                          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                          <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                                          <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                                      </svg>
                                                                            
                                                                            
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div data-draggable="true" class="card task-text-progress"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function() {
          // Listen for click on the Edit button
          document.querySelectorAll('.s-task-edit').forEach(function(editButton) {
              editButton.addEventListener('click', function() {
                  var taskId = this.getAttribute('data-id'); // Get the ID of the task
                  var taskContent = this.getAttribute('data-content'); // Get the content of the task

                  // Set the ID in the hidden input field of the modal
                  document.querySelector('#addTaskModal input[name="id"]').value = taskId;

                  // Set the content in the textarea for editing
                  document.querySelector('#s-task').value = taskContent;

                  // Change the modal title to "Edit Content"
                  document.querySelector('.edit-task-title').style.display = 'block';
                  document.querySelector('.add-task-title').style.display = 'none';
              });
          });
      });
  </script>

  <script>
      document.getElementById('openEnglishForm').addEventListener('click', function() {
          // Hide the language selection modal
          $('#languageSelectModal').modal('hide');
          // Show the English content modal
          $('#inputFormModal').modal('show');
      });

      document.getElementById('openTamilForm').addEventListener('click', function() {
          // Hide the language selection modal
          $('#languageSelectModal').modal('hide');
          // Show the Tamil content modal
          $('#inputFormModal_tamil').modal('show');
      });
  </script>

@include('admincms.include.footer');