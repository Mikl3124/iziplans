@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{$projet->title}}</h1>
    <h5>Mon offre pour ce projet</h5>
        <div class="row d-flex justify-content-between">
            <div class="card card-show mb-5 col-md-7 col-sm-12 mt-n5">
                <form>
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <div class="col-md-6 col-sm-6 my-1">
                                <label class="" for="inlineFormInputName">Mon offre</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inlineFormInputGroupUsername">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">€</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 my-1">
                                <label class="" for="inlineFormInputGroupUsername">Durée de réalisation</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inlineFormInputGroupUsername">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">jours</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 my-1 text-private">
                            <div class="form-group ">
                                <label for="exampleFormControlTextarea1">Message privé</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-12 my-1 text-private">
                            <div class="input-default">
                                <span class="drop-file-icon">
                                Upload your files
                                </span>
                                <span class="file-choose">
                                Choose file
                                </span>
                                <span class="noneI">
                                <input class="input-file" type="file" accept=".pdf,.jpeg,.png">
                                </span>
                            </div>
                            <ul class="fileN"></ul>
                        </div>
                        <div class="form-group">
                            <div class="col-auto my-1">
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
    {{-- ------------------------------------------------ Right part ----------------------------------------------- --}}
                <div class="col-md-4 my-2 col-sm-12 mt-n5">
                    <div class="card card-show bg-dark mb-3">
                        <p class="text-white">Le client n'a pas encore choisi son prestataire. Dépêchez-vous, il est encore temps de proposer votre devis.</p>
                        @guest
                            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">Faire une offre</button>
                        @endguest
                        @auth
                            <a href="{{route('offers.create', $projet)}}" class="btn btn-success">Faire une offre</a>
                        @endauth
                    </div>
                    <div class="card">
                        <div>
                            <p class="text-white">Le client n'a pas encore choisi son prestataire. Dépêchez-vous, il est encore temps de proposer votre devis.</p>
                            <button class="btn btn-primary">Contacter le client</button>
                        </div>
                    </div>
                </div>
        </div>



</div>

<script>
   // Put code here
// For uploading file
    var clickFile = document.querySelector(".file-choose");
    var inputFile = document.querySelector(".input-file");
    console.log("Input file: ", inputFile);
    clickFile.addEventListener("click", function(event) {
        console.log("event ", event);
        console.log("File: ", inputFile);
        inputFile.click();
      // alert("clicked");
    });
    inputFile.addEventListener("change", function() {
        if (inputFile.value) {
            var ul = document.querySelector(".fileN")
            ul.style.paddingTop = "20px";
            var li = document.createElement("li");
            var valueCont = document.createElement("span");
            var img = document.createElement("img");
            var imgCont = document.createElement("span");
            // img.src = "../images & Icons/cross.svg"
            var values = document.createTextNode(inputFile.value.substring(12));
            ul.append(li);
            li.append(valueCont, imgCont);
            imgCont.append(values, img);
            valueCont.append(values);
            li.setAttribute("class", "list")
            imgCont.setAttribute("class", "removeSearch")
            valueCont.setAttribute("class", "values")
            input.value = null;
            imgCont.addEventListener("click", function() {
                this.parentNode.remove();
                if (!ul.hasChildNodes()) {
                    ul.style.paddingTop = "0px";
                } else {

                }
            })
        }
    });
    // For uploading file (End)
</script>

@endsection