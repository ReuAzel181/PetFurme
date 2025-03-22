<div class="modal fade" id="findingsModal" tabindex="-1" role="dialog" aria-labelledby="findingsModalLabel" aria-hidden="true" data-bs-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="findingsModalLabel">Medical Findings</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="findingsForm">
                    @csrf
                    <meta name="user-id" content="{{ auth()->id() }}">
                    <input type="hidden" name="appointment_id" id="findings_appointment_id">
                    
                    <!-- Dynamic Fields Based on Reason -->
                    <div id="dynamicFindingsFields">
                        <!-- Fields will be populated dynamically -->
                    </div>

                    <!-- Additional Notes -->
                    <div class="mb-3">
                        <label class="form-label">Additional Notes</label>
                        <textarea class="form-control" name="additional_notes" rows="3"></textarea>
                    </div>

                    <!-- Recommendations -->
                    <div class="mb-3">
                        <label class="form-label">Recommendations</label>
                        <textarea class="form-control" name="recommendations" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveFindings()">Save Findings</button>
            </div>
        </div>
    </div>
</div> 