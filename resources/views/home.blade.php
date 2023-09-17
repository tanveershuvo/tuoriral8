@extends('components.app')

@section('title', 'Submission')

@section('content')
<div class="row my-4 ">
    <div class="col-sm-6 d-flex align-items-stretch">
        <div class="card border-primary">
            <div class="card-body text-center">
                <img src="../img/utas.png" alt="card image 1" class="img-fluid card-img-top mb-2"><br>
                <h3 class="card-title py-2">What is the<span class="text-warning"> UTAS SmartSpend (USS)? </span></h3>
                <p class="card-text"><span class="text-warning"> Utas SmartSpend (USS)</span> is our user-friendly web-based expense management system designed specifically
                    for the you at the University of Tasmania. USS empowers you to submit your expense reports and enables your HOD to efficiently manage.
                </p>

            </div>
            <div class="card-footer text-center">
                <span class="text-warning">USS</span> streamlines the workflow between staff and managers, ensuring a seamless
                and efficient process for expense management.
            </div>
        </div>
    </div>
    <div class="col-sm-6 d-flex align-items-stretch">
        <div class="card border-primary">
            <div class="card-body text-center">
                <img src="../img/signup.png" alt="card image 2" class="img-fluid card-img-top2">
                <h5 class="card-title py-2">Join the USS Today!</h5>
                <p>We can help you streamline workflow between you and your managers, relieving you
                    of stress and ensuring seamless process for your expense reports</p>
                <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#regModal" >Register Here</a>
            </div>
        </div>
    </div>
</div>

@endsection
