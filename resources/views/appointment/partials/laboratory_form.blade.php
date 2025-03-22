<div class="laboratory-fields">
    <input type="hidden" name="service_table" value="appt_laboratory">
    
    <div class="mb-3">
        <label class="form-label required">Test Type</label>
        <select name="laboratory[test_type]" class="form-select" required>
            <option value="">Select test type</option>
            <option value="blood_test">Blood Test</option>
            <option value="fecal_exam">Fecal Examination</option>
            <option value="urine_analysis">Urine Analysis</option>
            <option value="x_ray">X-Ray</option>
            <option value="ultrasound">Ultrasound</option>
            <option value="other">Other</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Additional Notes</label>
        <textarea name="laboratory[notes]" class="form-control" rows="3"></textarea>
    </div>
</div> 