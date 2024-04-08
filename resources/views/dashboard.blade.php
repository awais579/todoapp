<x-app-layout>


    <div class="container">
        <h1 class="fw-bold text-center my-3 fs-3">My Todo App</h1>
        <div class="row justify-content-between align-items-center ">

            <div class="col-lg-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary bg-primary ms-2 btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Create Category
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('create_category') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="text" name='name' placeholder="Create Category"
                                                class="form-control">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary bg-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary bg-primary">Create</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- -------------------Model End--------------------- -->
                        <form action="{{ route('add_task') }}" class="mt-3">
                            @csrf
                            <div class="row p-2">
                                <div class="col-md-12">
                                    <label for="task">Task</label>
                                    <input type="text" name="description" class="form-control-plaintext "
                                        id="task" placeholder="Enter a Task...">
                                </div>
                                @error('description')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                <div class="row justify-content-between">
                                    <div class="col-md-6 mt-3">
                                        <label for="">Select Category</label>
                                        <select name="category" class='w-100 form-control '>
                                            @if (!empty($categories))
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">No categories </option>

                                            @endif
                                        </select>
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                      

                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="category">Priority</label>
                                        <select name="priority" class="w-100 form-control">
                                            <option value="low">low</option>
                                            <option value="medium">medium</option>
                                            <option value="high">high</option>
                                        </select>
                                    </div>
                                    @error('priority')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>


                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="">Due Date</label>
                                    <input type="date" name="due_date" class="w-100 form-control">
                                </div>
                                @error('due_date')
                                        <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-3">
                                <!-- <a href="{{ route('add_task') }}" class="btn btn-success btn-sm">Add Task</a>                             -->
                                <button type="submit" class="btn btn-success btn-sm bg-success">Add Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 p-3 card overflow-y-scroll " style="height:400px">
                <div class="d-flex w-100  justify-content-between ">
                    <div>
                        <h1 class="fw-bold mb-3">Task List</h1>
                    </div>
                 

                </div>
                <div class="row justify-content-between ">
                    <div class="col-md-3">
                        <label for="">Select Category</label>

                        <select onchange="getData(event)" name="selectedValue" id="selectedCategory" class='w-100 form-control'>
                         
                            @if (!empty($categories))
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                @endforeach
                            @else
                                <option value="">No categories </option>

                            @endif
                        </select>

                        </form>
                    </div>
                    <div class="col-md-3">
                        <label for="category">Priority</label>
                        <select onchange="getData(event)" name="pTwo" class="w-100 form-control" id="priorityVal">
                           
                            <option value="low">low</option>
                            <option value="medium">medium</option>
                            <option value="high">high</option>
                        </select>
                        @error('priority')
                             <p class="text-danger">{{ $message }}</p>
                         @enderror
                    </div>
                </div>

                <div id="Category">
                </div>

               
                <hr>
                <hr>
                <div id="completed">
                   
                </div>

                
            </div>
        </div>


        <script>
           

            const getData = (e) => {
                
                e.preventDefault();
                var selected_category_elem = document.querySelector('#selectedCategory');
                var priority_elem = document.querySelector('#priorityVal');
                var cat_elem = document.querySelector('#Category');
                var comp_elem = document.querySelector('#completed');
                console.log(selected_category_elem.value , priority_elem.value);

                axios.post(`{{route('filter')}}`, {
                    category: selected_category_elem.value,
                    priority:priority_elem.value,
                    
                }).then(res => {
                    console.log(res.data.length);
                    
                    if(res.data.length < 1){
                        let html = '<h1 class="mt-4 ms-3">no task.....</h1>';
                        cat_elem.innerHTML = html;
                    }
                  else{

                 
                    let html = res.data.map(element => {
                        
                        return `
                            <li class="border p-3 col-md-3 mx-3 mb-2 ">
                                <ul class="d-flex flex-column  align-items-start justify-content-between ">
                                    <li>${element.description}</li>
                                    <li>${element.due_date}</li>
                                    <li>${element.priority}</li>
                                    <li>${element.category}</li>
                                    <li>
                                        <a href="{{ route('delete_task', '__:param') }}"> 
                                            <i class="fa-solid fa-trash text-danger"></i>
                                        </a>
                                        <a href="{{ route('edit_tasks', '__:param') }}">
                                            <i class="fa-solid fa-pen-to-square ms-3 text-warning "></i>
                                        </a>
                                        <input type="checkbox"  onclick="getVal(${element.id})" class="ms-3 mb-1" id="cb-1" />
                                    </li>
                                </ul>
                            </li>
                        `.replaceAll('__:param', element.id)
                    });
                    cat_elem.innerHTML = `<ul class="mt-4">
                        <div class="row justify-content-between align-items-center g-2">${html.join('')}</div>
                    </ul>`;
                  }
                    
                

                }).catch(err => {
                    console.error(err);
                })
            }
            function getVal(id) {
                    var comp_elem = document.querySelector('#completed');
                    var cat_elem = document.querySelector('#Category');
                    var checkbox = document.getElementById('cb-1').checked;
                        console.log(id ,checkbox);
                        axios.post('/change_Status', {
                            id,
                            taskStatus: checkbox
                        }).then((res) => {
                         var data = res.data.filterTask;
                        //  window.location.reload();
                        // complete
                        var completefilterData = data.filter((item)=>{
                            return item.status == 'complete';
                         })
                        //  uncomplete
                         var uncompletefilterData = data.filter((item)=>{
                            return item.status == 'uncomplete';
                         })

                        // uncomplete
                        let htmltwo = uncompletefilterData.map(element => {

                        return `
                            <li class="border p-3 col-md-3 mx-3 mb-2 ">
                                <ul class="d-flex flex-column  align-items-start justify-content-between ">
                                    <li>${element.description}</li>
                                    <li>${element.due_date}</li>
                                    <li>${element.priority}</li>
                                    <li>${element.category}</li>
                                    <li>
                                        <a href="{{ route('delete_task', '__:param') }}"> 
                                            <i class="fa-solid fa-trash text-danger"></i>
                                        </a>
                                        <a href="{{ route('edit_tasks', '__:param') }}">
                                            <i class="fa-solid fa-pen-to-square ms-3 text-warning "></i>
                                        </a>
                                        <input type="checkbox"  onclick="getVal(${element.id})" class="ms-3 mb-1" id="cb-${element.id}" />
                                    </li>
                                </ul>
                            </li>
                        `.replaceAll('__:param', element.id)
                        });

                        cat_elem.innerHTML = `<ul class="mt-4">
                            <div class="row justify-content-between align-items-center g-2">${htmltwo.join('')}</div>
                        </ul>`;
                            
                    // complete
                    let html = completefilterData.map(element => {

                        return `
                            <li class="border p-3 col-md-3 mx-3 mb-2 ">
                                <ul class="d-flex flex-column  align-items-start justify-content-between ">
                                    <li>${element.description}</li>
                                    <li>${element.due_date}</li>
                                    <li>${element.priority}</li>
                                    <li>${element.category}</li>
                                    <li>
                                        <a href="{{ route('delete_task', '__:param') }}"> 
                                            <i class="fa-solid fa-trash text-danger"></i>
                                        </a>
                                        <a href="{{ route('edit_tasks', '__:param') }}">
                                            <i class="fa-solid fa-pen-to-square ms-3 text-warning "></i>
                                        </a>
                                        <input type="checkbox"  onclick="getVal(${element.id})" class="ms-3 mb-1" id="cb-1" />
                                    </li>
                                </ul>
                            </li>
                        `.replaceAll('__:param', element.id)
                        });

                         
                          

                        comp_elem.innerHTML = `<ul class="mt-4">
                            <div class="row justify-content-between align-items-center g-2">${html.join('')}</div>
                        </ul>`;

                        }).catch((err) => {
                            console.log(err)
                        });
                  }

                  document.addEventListener('DOMContentLoaded', ()=>{
                    axios.get('{{ route('gettasks')}}').then(res => {
                        let html = res.data.map((element) => {
                            console.log(res.data);
                            return `<li class="border p-3 col-md-3 mx-3 mb-2 ">
                                    <ul class="d-flex flex-column  align-items-start justify-content-between ">
                                        <li>${element.description}</li>
                                        <li>${element.due_date}</li>
                                        <li>${element.priority}</li>
                                        <li>${element.category}</li>
                                        <li>
                                            <a href="{{ route('delete_task', '__:param') }}"> 
                                                <i class="fa-solid fa-trash text-danger"></i>
                                            </a>
                                            <a href="{{ route('edit_tasks', '__:param') }}">
                                                <i class="fa-solid fa-pen-to-square ms-3 text-warning "></i>
                                            </a>
                                            <input type="checkbox"  onclick="getVal(${element.id})" class="ms-3 mb-1" id="cb-1" />
                                        </li>
                                    </ul>
                                </li>
                            `.replaceAll('__:param', element.id)
                        });
                    let cat_elem = document.querySelector('#Category');
                  
                    cat_elem.innerHTML = `<ul class="mt-4">
                            <div class="row justify-content-between align-items-center g-2">${html.join('')}</div>
                        </ul>`;

                    }).catch(err => {
                        console.error(err);
                    })
                  })
        </script>
</x-app-layout>
            
