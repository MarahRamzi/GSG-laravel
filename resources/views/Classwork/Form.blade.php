@if(session()->has('error'))
    <div class="alert alert-danger container">
        {{ session()->get('error') }}
    </div>
@endif

<div class="col-md-8">
    <div class="form-floating mb-4 mt-3">
        <input type="input" @class(['form-control', 'is-invalid' => $errors->has('title')]) id="title" name = "title" placeholder="Enter Classwork Title" value={{ old('title',$classwork->title) }} >
        <label for="title">Title</label>
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-floating mb-4 mt-3">
        <textarea @class(['form-control', 'is-invalid' => $errors->has('descreption')]) id="descreption" name="descreption" style="height: 100px" placeholder="Enter Classwork descreption">
            {{ old('descreption' , $classwork->descreption) }}
        </textarea>
        <label for="descreption"></label>
      @error('descreption')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
</div>
<div class="col-md-4">

    <div class="form-floating mb-4 mt-3">
        <input type="date" @class(['form-control', 'is-invalid' => $errors->has('published_at')]) id="published_at" name = "published_at" :value=" $classwork->published_at ">
        <label for="published_at">publish Date</label>
        @error('published_at')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <h4>Students</h4>
    <div class="mb-3">
        @foreach ($classroom->students as $student)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name= "students[]" value="{{ $student->id }}" id="std-{{ $student->id }}" @checked( !isset($assigned) || in_array($student->id , $assigned )) />
            <label class="form-check-label" for="std-{{ $student->id }}">{{ $student->name }}</label>
        </div>
    @endforeach
    </div>

   @if($type == "assignment")
        <div class="form-floating mb-4 mt-3">
            <input type="number" min="0" @class(['form-control', 'is-invalid' => $errors->has('grade')]) id="grade" name = "grade" :value=" $classwork->options->grade ?? '' ">
            <label for="grade">Grade</label>
            @error('options.grade')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-4 mt-3">
            <input type="date" @class(['form-control', 'is-invalid' => $errors->has('due')]) id="due" name = "due" :value="$classwork->options['due'] ?? '' ">
            <label for="due">Due</label>
            @error('due')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
   @endif

    <div class="form-floating mb-3 mt-3">
        <select name="topic_id" id="topic_id" class="form-select">
            <option value="">No Topic</option>
            @foreach ($classroom->topics as $topic)
            <option @selected($topic->id == $classwork->topic_id) value="{{ $topic->id }}">{{ $topic->name }}</option>
            @endforeach
        </select>
        <label for="floatingSelect topic_id">Topic (optional)</label>
      @error('topic_id')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
</div>



@push('scripts')
    <script src="https://cdn.tiny.cloud/1/p0p17ajz76k68e8fz4oms3wxq9rf12gygwagcmy72uz0kms2/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
          selector: '#descreption',
          plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        });
      </script>
@endpush
