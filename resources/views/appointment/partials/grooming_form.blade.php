<div class="grooming-fields">
    <input type="hidden" name="service_table" value="appt_grooming">
    
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">Grooming Services</h3>
        </div>
        <div class="card-body">
            <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                <label class="form-selectgroup-item flex-fill">
                    <input type="checkbox" name="grooming[services_done][]" value="bath" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div>
                            <span class="payment-provider-title">Bath</span>
                            <span class="text-muted d-block mt-1">Full body shampoo and conditioning treatment</span>
                        </div>
                    </div>
                </label>
                <label class="form-selectgroup-item flex-fill">
                    <input type="checkbox" name="grooming[services_done][]" value="haircut" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div>
                            <span class="payment-provider-title">Haircut</span>
                            <span class="text-muted d-block mt-1">Professional styling and trimming</span>
                        </div>
                    </div>
                </label>
                <label class="form-selectgroup-item flex-fill">
                    <input type="checkbox" name="grooming[services_done][]" value="nail_trim" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div>
                            <span class="payment-provider-title">Nail Trim</span>
                            <span class="text-muted d-block mt-1">Gentle nail trimming and filing</span>
                        </div>
                    </div>
                </label>
                <label class="form-selectgroup-item flex-fill">
                    <input type="checkbox" name="grooming[services_done][]" value="ear_cleaning" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div>
                            <span class="payment-provider-title">Ear Cleaning</span>
                            <span class="text-muted d-block mt-1">Thorough ear cleaning and inspection</span>
                        </div>
                    </div>
                </label>
                <label class="form-selectgroup-item flex-fill">
                    <input type="checkbox" name="grooming[services_done][]" value="teeth_brushing" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div>
                            <span class="payment-provider-title">Teeth Brushing</span>
                            <span class="text-muted d-block mt-1">Dental cleaning with pet-safe toothpaste</span>
                        </div>
                    </div>
                </label>
                <label class="form-selectgroup-item flex-fill">
                    <input type="checkbox" name="grooming[services_done][]" value="flea_treatment" class="form-selectgroup-input">
                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                        <div class="me-3">
                            <span class="form-selectgroup-check"></span>
                        </div>
                        <div>
                            <span class="payment-provider-title">Flea Treatment</span>
                            <span class="text-muted d-block mt-1">Special flea shampoo and treatment</span>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Groomer</label>
                <input type="text" name="grooming[groomer]" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Haircut Style (if applicable)</label>
                <input type="text" name="grooming[haircut_style]" class="form-control">
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Special Requests</label>
        <textarea name="grooming[notes]" class="form-control" rows="3" placeholder="Any specific instructions or requests for the grooming session"></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Products Used</label>
        <select name="grooming[products_used][]" class="form-select" multiple>
            <option value="regular_shampoo">Regular Shampoo</option>
            <option value="oatmeal_shampoo">Oatmeal Shampoo (Sensitive Skin)</option>
            <option value="flea_shampoo">Flea & Tick Shampoo</option>
            <option value="conditioner">Conditioner</option>
            <option value="detangling_spray">Detangling Spray</option>
            <option value="cologne">Pet Cologne</option>
        </select>
        <small class="form-hint">Hold Ctrl/Cmd to select multiple products</small>
    </div>
</div> 