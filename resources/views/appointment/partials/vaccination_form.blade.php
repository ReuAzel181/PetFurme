<div class="vaccination-fields">
    <input type="hidden" name="service_table" value="appt_vaccinations">
    
    <div class="alert alert-info">
        <h4 class="alert-title">Vaccination Information</h4>
        <div class="text-muted">Please fill in all required fields for the vaccination record.</div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label required">Vaccine Type</label>
                <select name="vaccine[0][type]" class="form-select" required>
                    <option value="">Select vaccine type</option>
                    <option value="Rabies">Rabies</option>
                    <option value="DHPP">DHPP (Distemper, Hepatitis, Parainfluenza, Parvovirus)</option>
                    <option value="Bordetella">Bordetella (Kennel Cough)</option>
                    <option value="Leptospirosis">Leptospirosis</option>
                    <option value="Lyme Disease">Lyme Disease</option>
                    <option value="Canine Influenza">Canine Influenza</option>
                    <option value="FVRCP">FVRCP (Feline Viral Rhinotracheitis, Calicivirus, Panleukopenia)</option>
                    <option value="FeLV">FeLV (Feline Leukemia Virus)</option>
                    <option value="Other">Other (Specify in notes)</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label required">Batch Number</label>
                <input type="text" name="vaccine[0][batch_number]" class="form-control" required placeholder="Enter vaccine batch/lot number">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label required">Administered By</label>
                <input type="text" name="vaccine[0][administered_by]" class="form-control" required placeholder="Name of veterinarian or technician">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label required">Next Due Date</label>
                <input type="date" name="vaccine[0][next_due_date]" class="form-control" required>
                <small class="form-hint">When the next vaccination is due</small>
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Reactions/Notes</label>
        <textarea name="vaccine[0][reactions]" class="form-control" rows="3" placeholder="Any previous reactions or special notes"></textarea>
    </div>
    
    <!-- Hidden input to ensure proper validation -->
    <input type="hidden" name="reason_for_visit_type" value="Vaccination">
</div> 