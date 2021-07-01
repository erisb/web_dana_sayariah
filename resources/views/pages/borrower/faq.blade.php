@extends('layouts.borrower.master')

@section('title', 'Dasbor Admin')

@section('content')
    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
        <div class="content">
            <!-- Frequently Asked Questions -->
            <div class="row">
                <div id="col" class="col-12 col-md-12 mt-30">
                    <span class="mb-10 pb-10 ">
                        <h1 class="no-paddingTop font-w400 text-dark" style="float: left; margin-block-end: .6em;" >Frequently Asked Questions <small>( FAQ )</small> </h1>                    
                    </span>
                </div>
            </div>
            <!-- Introduction -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title text-dark">
                        <strong class="text-dark">1.</strong> Introduction
                    </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option">
                            <i class="si si-question"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div id="faq1" role="tablist" aria-multiselectable="true">
                        <div class="block block-bordered block-rounded mb-5">
                            <div class="block-header" role="tab" id="faq1_h1">
                                <a class="font-w600 text-body-color-dark text-dark" data-toggle="collapse" href="#faq1_q1" aria-expanded="true" aria-controls="faq1_q1">1.1 Welcome to your own dashboard</a>
                            </div>
                            <div id="faq1_q1" class="collapse show" role="tabpanel" aria-labelledby="faq1_h1" data-parent="#faq1">
                                <div class="block-content border-t">
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                </div>
                            </div>
                        </div>
                        <div class="block block-bordered block-rounded mb-5">
                            <div class="block-header" role="tab" id="faq1_h2">
                                <a class="font-w600 text-body-color-dark text-dark" data-toggle="collapse" href="#faq1_q2" aria-expanded="true" aria-controls="faq1_q2">1.2 The team behind the project</a>
                            </div>
                            <div id="faq1_q2" class="collapse" role="tabpanel" aria-labelledby="faq1_h2" data-parent="#faq1">
                                <div class="block-content border-t">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-3">
                                            <a class="block block-link-pop" href="javascript:void(0)">
                                                <div class="block-content block-content-full text-center">
                                                    <img class="img-avatar" src="assetsBorrower/media/avatars/avatar4.jpg" alt="">
                                                </div>
                                                <div class="block-content block-content-full bg-body-light text-center">
                                                    <div class="font-w600 mb-5 text-dark">Helen Jacobs</div>
                                                    <div class="font-size-sm text-muted">Web Designer</div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                            <a class="block block-link-pop" href="javascript:void(0)">
                                                <div class="block-content block-content-full text-center">
                                                    <img class="img-avatar" src="assetsBorrower/media/avatars/avatar11.jpg" alt="">
                                                </div>
                                                <div class="block-content block-content-full bg-body-light text-center">
                                                    <div class="font-w600 mb-5 text-dark">Jose Wagner</div>
                                                    <div class="font-size-sm text-muted">Web Development</div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                            <a class="block block-link-pop" href="javascript:void(0)">
                                                <div class="block-content block-content-full text-center">
                                                    <img class="img-avatar" src="assetsBorrower/media/avatars/avatar14.jpg" alt="">
                                                </div>
                                                <div class="block-content block-content-full bg-body-light text-center">
                                                    <div class="font-w600 mb-5 text-dark">Ryan Flores</div>
                                                    <div class="font-size-sm text-muted">Photographer</div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                            <a class="block block-link-pop" href="javascript:void(0)">
                                                <div class="block-content block-content-full text-center">
                                                    <img class="img-avatar" src="assetsBorrower/media/avatars/avatar4.jpg" alt="">
                                                </div>
                                                <div class="block-content block-content-full bg-body-light text-center">
                                                    <div class="font-w600 mb-5 text-dark">Carol Ray</div>
                                                    <div class="font-size-sm text-muted">Graphic Designer</div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block block-bordered block-rounded mb-5">
                            <div class="block-header" role="tab" id="faq1_h3">
                                <a class="font-w600 text-body-color-dark text-dark" data-toggle="collapse" href="#faq1_q3" aria-expanded="true" aria-controls="faq1_q3">1.3 What are our values?</a>
                            </div>
                            <div id="faq1_q3" class="collapse" role="tabpanel" aria-labelledby="faq1_h3" data-parent="#faq1">
                                <div class="block-content border-t">
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                </div>
                            </div>
                        </div>
                        <div class="block block-bordered block-rounded mb-5">
                            <div class="block-header" role="tab" id="faq1_h4">
                                <a class="font-w600 text-body-color-dark text-dark" data-toggle="collapse" href="#faq1_q4" aria-expanded="true" aria-controls="faq1_q4">1.4 What are our future plans?</a>
                            </div>
                            <div id="faq1_q4" class="collapse" role="tabpanel" aria-labelledby="faq1_h4" data-parent="#faq1">
                                <div class="block-content border-t">
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Introduction -->

            <!-- Functionality -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title text-dark">
                        <strong class="text-dark">2.</strong> Functionality
                    </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option">
                            <i class="si si-question"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div id="faq2" role="tablist" aria-multiselectable="true">
                        <div class="block block-bordered block-rounded mb-5">
                            <div class="block-header" role="tab" id="faq2_h1">
                                <a class="font-w600 text-body-color-dark text-dark" data-toggle="collapse" href="#faq2_q1" aria-expanded="true" aria-controls="faq2_q1">What are the key features?</a>
                            </div>
                            <div id="faq2_q1" class="collapse" role="tabpanel" aria-labelledby="faq2_h1" data-parent="#faq2">
                                <div class="block-content border-t">
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                    <ul class="fa-ul list-li-push-sm">
                                        <li class="text-dark">
                                            <i class="fa fa-check fa-li text-dark"></i> Fully Responsive
                                        </li>
                                        <li class="text-dark">
                                            <i class="fa fa-check fa-li text-dark"></i> API Support
                                        </li>
                                        <li class="text-dark">
                                            <i class="fa fa-check fa-li text-dark"></i> Dynamic and real time data
                                        </li>
                                        <li class="text-dark">
                                            <i class="fa fa-check fa-li text-dark"></i> Security
                                        </li>
                                    </ul>
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                </div>
                            </div>
                        </div>
                        <div class="block block-bordered block-rounded mb-5">
                            <div class="block-header" role="tab" id="faq2_h2">
                                <a class="font-w600 text-body-color-dark text-dark" data-toggle="collapse" href="#faq2_q2" aria-expanded="true" aria-controls="faq2_q2">How to use your dashboard?</a>
                            </div>
                            <div id="faq2_q2" class="collapse" role="tabpanel" aria-labelledby="faq2_h2" data-parent="#faq2">
                                <div class="block-content border-t">
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                </div>
                            </div>
                        </div>
                        <div class="block block-bordered block-rounded mb-5">
                            <div class="block-header" role="tab" id="faq2_h3">
                                <a class="font-w600 text-body-color-dark text-dark" data-toggle="collapse" href="#faq2_q3" aria-expanded="true" aria-controls="faq2_q3">How easy can I connect to third party services?</a>
                            </div>
                            <div id="faq2_q3" class="collapse" role="tabpanel" aria-labelledby="faq2_h3" data-parent="#faq2">
                                <div class="block-content border-t">
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                </div>
                            </div>
                        </div>
                        <div class="block block-bordered block-rounded mb-5">
                            <div class="block-header" role="tab" id="faq2_h4">
                                <a class="font-w600 text-body-color-dark text-dark" data-toggle="collapse" href="#faq2_q4" aria-expanded="true" aria-controls="faq2_q4">How secure is my data?</a>
                            </div>
                            <div id="faq2_q4" class="collapse" role="tabpanel" aria-labelledby="faq2_h4" data-parent="#faq2">
                                <div class="block-content border-t">
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Functionality -->

            <!-- Payments -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title text-dark">
                        <strong class="text-dark">3.</strong> Payments
                    </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option">
                            <i class="si si-question"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div id="faq3" role="tablist" aria-multiselectable="true">
                        <div class="block block-bordered block-rounded mb-5">
                            <div class="block-header" role="tab" id="faq3_h1">
                                <a class="font-w600 text-body-color-dark text-dark" data-toggle="collapse" href="#faq3_q1" aria-expanded="true" aria-controls="faq3_q1">What are the available plans?</a>
                            </div>
                            <div id="faq3_q1" class="collapse" role="tabpanel" aria-labelledby="faq3_h1" data-parent="#faq3">
                                <div class="block-content border-t">
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                </div>
                            </div>
                        </div>
                        <div class="block block-bordered block-rounded mb-5">
                            <div class="block-header" role="tab" id="faq3_h2">
                                <a class="font-w600 text-body-color-dark text-dark" data-toggle="collapse" href="#faq3_q2" aria-expanded="true" aria-controls="faq3_q2">What are the available withdrawal options?</a>
                            </div>
                            <div id="faq3_q2" class="collapse" role="tabpanel" aria-labelledby="faq3_h2" data-parent="#faq3">
                                <div class="block-content border-t">
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                    <p class="text-dark">Potenti elit lectus augue eget iaculis vitae etiam, ullamcorper etiam bibendum ad feugiat magna accumsan dolor, nibh molestie cras hac ac ad massa, fusce ante convallis ante urna molestie vulputate bibendum tempus ante justo arcu erat accumsan adipiscing risus, libero condimentum venenatis sit nisl nisi ultricies sed, fames aliquet consectetur consequat nostra molestie neque nullam scelerisque neque commodo turpis quisque etiam egestas vulputate massa, curabitur tellus massa venenatis congue dolor enim integer luctus, nisi suscipit gravida fames quis vulputate nisi viverra luctus id leo dictum lorem, inceptos nibh orci.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Payments -->
            <!-- END Frequently Asked Questions -->
        </div>
        <!-- END Page Content -->

        </main>
        <!-- END Main Container -->
@endsection
    