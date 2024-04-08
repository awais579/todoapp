<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
 <h3 class="text-center mt-5">Edit Task</h3>
   <div class="container">
    <div class="row align-items-sm-center justify-content-center">
        <div class="col-md-8">
      
               <form method="Post" action="{{url ('save_editied', ['id' => $tasks->id])}}">
                     @csrf
                           <div>
                              <label for="">Task</label>
                              <input type="text" name="description" value="{{$tasks->description}}"  class="form-control"  >
                           </div>
                           <div>
                              <label for="">Due Date</label>
                              <input type="date" name="due_date" value="{{$tasks->due_date}}" class="form-control"  >
                           </div>
                           <div>
                              <label for="">Priority</label>
                              
                              <input type="text" name="priority" value="{{$tasks->priority}}" class="form-control"  >
                           </div>
                           <div>
                              <label for="">Category</label>
                              <input type="text" name="category" value="{{$tasks->category}}" class="form-control"  >
                           </div>
                           <div class="mt-3 d-flex  justify-content-between ">
                              <a href="{{route('view_task')}}" >Go Back</a>
                              <button type="submit" >Update Task</button>
                           </div>
                </form>
               </div>
            </div>
         </div>
      </body>
</html>