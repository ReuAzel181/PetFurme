<?php $__env->startSection('content'); ?>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Management</h3>
            </div>
            <div class="card-body">
                <div class="row row-cards">
                    <div class="col-md-6 mb-4">
                        <div class="card card-link card-link-pop h-100">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-green">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stethoscope" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" />
                                        <path d="M8 15a6 6 0 1 0 12 0v-3" />
                                        <path d="M11 3v2" />
                                        <path d="M6 3v2" />
                                        <circle cx="20" cy="10" r="2" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title">Medical Records</h3>
                                <p class="text-muted flex-grow-1">
                                    View and manage patient medical records, diagnoses, and treatment histories.
                                </p>
                                <div class="mt-3">
                                    <a href="<?php echo e(route('pages.medical-records')); ?>" class="btn btn-green">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-medical me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M10 14h4" />
                                            <path d="M12 12v4" />
                                        </svg>
                                        View Records
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card card-link card-link-pop h-100">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-truck-delivery" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title">Suppliers</h3>
                                <p class="text-muted flex-grow-1">
                                    Manage your suppliers and their contact information.
                                </p>
                                <div class="mt-3">
                                    <a href="<?php echo e(route('suppliers.index')); ?>" class="btn btn-primary">
                                        View Suppliers
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card card-link card-link-pop h-100">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-green">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 4h6v6h-6z" />
                                        <path d="M14 4h6v6h-6z" />
                                        <path d="M4 14h6v6h-6z" />
                                        <path d="M14 14h6v6h-6z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h2 class="card-title">Categories</h2>
                                <p class="text-muted flex-grow-1">Organize products by categories</p>
                                <div class="mt-4">
                                    <div class="d-flex mb-2">
                                        <div class="stat-label">Total Categories</div>
                                        <div class="ms-auto">
                                            <span class="badge bg-green stat-badge">
                                                <?php echo e(\App\Models\Category::count()); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-green w-100">
                                    Manage Categories
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card card-link card-link-pop h-100">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-orange">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ruler-2" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M17 3l4 4l-14 14l-4 -4z" />
                                        <path d="M16 7l-1.5 -1.5" />
                                        <path d="M13 10l-1.5 -1.5" />
                                        <path d="M10 13l-1.5 -1.5" />
                                        <path d="M7 16l-1.5 -1.5" />
                                    </svg>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h2 class="card-title">Units</h2>
                                <p class="text-muted flex-grow-1">Define measurement units for products</p>
                                <div class="mt-4">
                                    <div class="d-flex mb-2">
                                        <div class="stat-label">Total Units</div>
                                        <div class="ms-auto">
                                            <span class="badge bg-orange stat-badge">
                                                <?php echo e(\App\Models\Unit::count()); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="<?php echo e(route('units.index')); ?>" class="btn btn-orange w-100">
                                    Manage Units
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('css'); ?>
<style>
    /* Card titles */
    .card-title {
        font-size: 2.4rem;
        font-weight: 700;
        margin-bottom: 1.2rem;
        color: #1a2c4e;
    }
    
    /* Description text */
    .text-muted {
        font-size: 1.3rem;
        line-height: 1.6;
        color: #475569 !important;
    }
    
    /* Stats label */
    .stat-label {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    /* Stats badge */
    .stat-badge {
        font-size: 1.5rem;
        padding: 0.8em 1.4em;
        font-weight: 700;
        min-width: 3.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.08);
        border-radius: 8px;
    }
    
    /* Buttons */
    .btn {
        font-size: 1.3rem;
        padding: 1.2rem 1.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.07);
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(0,0,0,0.1);
    }
    
    /* Card styling */
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02), 
                    0 10px 15px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }
    
    .card-link-pop:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0,0,0,0.05), 
                    0 12px 18px rgba(0,0,0,0.05);
    }
    
    /* Card body padding */
    .card-body {
        padding: 2.5rem;
    }
    
    /* Card footer */
    .card-footer {
        padding: 1.8rem 2.5rem;
        background: transparent;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    
    /* Icons in stamp */
    .card-stamp-icon {
        width: 7rem;
        height: 7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        opacity: 0.9;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        backdrop-filter: blur(4px);
    }
    
    .card-stamp {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        padding: 1.5rem;
    }
    
    /* Button colors with enhanced gradients */
    .btn-green {
        background: linear-gradient(145deg, #2fb344, #28a33c);
        border: none;
        color: #fff !important;
    }
    .btn-green:hover {
        background: linear-gradient(145deg, #28a33c, #239035);
    }
    
    .btn-orange {
        background: linear-gradient(145deg, #f76707, #e85f06);
        border: none;
        color: #fff !important;
    }
    .btn-orange:hover {
        background: linear-gradient(145deg, #e85f06, #d95805);
    }
    
    .btn-primary {
        background: linear-gradient(145deg, #206bc4, #1d60b0);
        border: none;
        color: #fff !important;
    }
    .btn-primary:hover {
        background: linear-gradient(145deg, #1d60b0, #1a559d);
    }
    
    /* Main container spacing */
    .container-xl {
        padding: 2rem;
    }
    
    /* Row spacing */
    .row-cards {
        gap: 2rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-title {
            font-size: 2rem;
        }
        .text-muted {
            font-size: 1.2rem;
        }
        .stat-badge {
            font-size: 1.3rem;
        }
        .card-stamp-icon {
            width: 5rem;
            height: 5rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.tabler', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/pages/index.blade.php ENDPATH**/ ?>