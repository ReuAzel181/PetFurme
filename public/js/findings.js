// Mapping of appointment reasons to their specific fields
const reasonFields = {
    'Vaccination': [
        { name: 'type', label: 'Vaccine Type', type: 'select', options: ['DHPP', 'Rabies', 'Bordetella', 'FVRCP', 'FeLV'] },
        { name: 'batch_number', label: 'Batch Number', type: 'text' },
        { name: 'date_given', label: 'Date Given', type: 'date', value: new Date().toISOString().split('T')[0] },
        { name: 'next_due_date', label: 'Next Due Date', type: 'date' },
        { name: 'administered_by', label: 'Administered By', type: 'text' }
    ],
    'Grooming': [
        { name: 'services_done', label: 'Services Done', type: 'checkbox', 
          options: ['Bath', 'Nail Trim', 'Ear Cleaning', 'Teeth Brushing', 'Full Grooming'] },
        { name: 'products_used', label: 'Products Used', type: 'textarea' },
        { name: 'notes', label: 'Additional Notes', type: 'textarea' }
    ],
    'Surgery': [
        { name: 'surgery_type', label: 'Surgery Type', type: 'text' },
        { name: 'pre_surgery_notes', label: 'Pre-Surgery Notes', type: 'textarea' },
        { name: 'anesthesia_used', label: 'Anesthesia Used', type: 'text' },
        { name: 'procedure_notes', label: 'Procedure Notes', type: 'textarea' },
        { name: 'recovery_notes', label: 'Recovery Notes', type: 'textarea' },
        { name: 'post_surgery_care', label: 'Post-Surgery Care', type: 'textarea' },
        { name: 'follow_up_date', label: 'Follow-up Date', type: 'date' }
    ],
    'Laboratory': [
        { name: 'test_type', label: 'Test Type', type: 'select', 
          options: ['Blood Test', 'Urinalysis', 'Fecal Test', 'X-Ray', 'Ultrasound']},
        { name: 'results', label: 'Test Results', type: 'textarea' },
        { name: 'interpretation', label: 'Interpretation', type: 'textarea' },
        { name: 'recommendations', label: 'Recommendations', type: 'textarea' },
        { name: 'date_performed', label: 'Date Performed', type: 'date', value: new Date().toISOString().split('T')[0] },
        { name: 'follow_up_date', label: 'Follow-up Date', type: 'date' }
    ],
    'Check-up': [
        { name: 'service_type', label: 'Service Type', type: 'text', value: 'Check-up' },
        { name: 'findings', label: 'Findings', type: 'textarea' },
        { name: 'vital_signs', label: 'Vital Signs', type: 'textarea' },
        { name: 'treatment', label: 'Treatment', type: 'textarea' },
        { name: 'medications', label: 'Medications', type: 'textarea' },
        { name: 'next_visit', label: 'Next Visit', type: 'date' },
        { name: 'notes', label: 'Additional Notes', type: 'textarea' }
    ],
    'Consultation': [
        { name: 'service_type', label: 'Service Type', type: 'text', value: 'Consultation' },
        { name: 'findings', label: 'Findings', type: 'textarea' },
        { name: 'vital_signs', label: 'Vital Signs', type: 'textarea' },
        { name: 'treatment', label: 'Treatment', type: 'textarea' },
        { name: 'medications', label: 'Medications', type: 'textarea' },
        { name: 'next_visit', label: 'Next Visit', type: 'date' },
        { name: 'notes', label: 'Additional Notes', type: 'textarea' }
    ]
};

function showFindingsModal(appointmentId, reasonForVisit) {
    console.log('Pet ID:', appointmentId);
    console.log('Reason for visit:', reasonForVisit);
    
    // Remove any existing backdrops first
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.remove();
    });

    // Handle both string and array inputs for reasonForVisit
    let reasons;
    if (typeof reasonForVisit === 'string') {
        reasons = reasonForVisit.split(',').map(r => r.trim());
    } else if (Array.isArray(reasonForVisit)) {
        reasons = reasonForVisit.map(r => {
            if (typeof r === 'string') {
                try {
                    const parsed = JSON.parse(r);
                    return Array.isArray(parsed) ? parsed[0] : r;
                } catch (e) {
                    return r;
                }
            }
            return r;
        });
    } else {
        reasons = ['Consultation'];
    }

    reasons = [...new Set(reasons)].filter(reason => reasonFields[reason]);
    if (reasons.length === 0) reasons = ['Consultation'];
    
    // Clear existing fields
    document.getElementById('dynamicFindingsFields').innerHTML = '';
    document.getElementById('findings_appointment_id').value = appointmentId;
    
    // Generate fields for each reason
    reasons.forEach(reason => {
        const fields = reasonFields[reason] || [];
        if (fields.length === 0) return;

        const sectionHtml = `
            <div class="card mb-3">
                <div class="card-header bg-light py-2">
                    <h6 class="card-title mb-0">${reason} Details</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row g-2">
                        ${fields.map(field => {
                            const colWidth = field.type === 'textarea' ? '12' : 
                                           field.type === 'checkbox' ? '12' : '6';
                            
                    return `
                            <div class="col-md-${colWidth}">
                                <div class="mb-2">
                                    <label class="form-label small mb-1">${field.label}</label>
                                    ${field.type === 'select' ? `
                                        <select class="form-select form-select-sm" name="${reason.toLowerCase()}_${field.name}">
                                <option value="">Select ${field.label}</option>
                                ${field.options.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                            </select>
                                    ` : field.type === 'textarea' ? `
                                        <textarea class="form-control form-control-sm" name="${reason.toLowerCase()}_${field.name}" 
                                                 rows="2" style="resize: none;"></textarea>
                                    ` : field.type === 'checkbox' ? `
                                        <div class="d-flex flex-wrap gap-2">
                                ${field.options.map(opt => `
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="${reason.toLowerCase()}_${field.name}" value="${opt}">
                                                    <label class="form-check-label small">${opt}</label>
                                    </div>
                                `).join('')}
                                        </div>
                                    ` : `
                                        <input type="${field.type}" class="form-control form-control-sm" 
                                               name="${reason.toLowerCase()}_${field.name}"
                                               ${field.value ? `value="${field.value}"` : ''}>
                                    `}
                                </div>
                            </div>`;
                        }).join('')}
                    </div>
                            </div>
                        </div>`;
                
        document.getElementById('dynamicFindingsFields').innerHTML += sectionHtml;
    });

    // Get both modals
    const findingsModal = document.getElementById('findingsModal');
    const chargeSlipModal = document.getElementById('medicalRecordModal');

    // Remove chief complaint section if it exists
    const chiefComplaintSection = findingsModal.querySelector('.chief-complaint');
    if (chiefComplaintSection) {
        chiefComplaintSection.remove();
    }

    // Ensure charge slip modal stays visible without dimming
    chargeSlipModal.style.display = 'block';
    chargeSlipModal.classList.add('show');
    chargeSlipModal.style.zIndex = '1050';
    chargeSlipModal.style.opacity = '1';

    // Set up the findings modal to appear above
    findingsModal.style.display = 'block';
    findingsModal.classList.add('show');
    findingsModal.removeAttribute('aria-hidden');
    findingsModal.setAttribute('aria-modal', 'true');
    findingsModal.setAttribute('role', 'dialog');
    findingsModal.style.zIndex = '1060';
    findingsModal.style.background = 'rgba(0, 0, 0, 0.1)';

    // Center the modal dialog with improved styling
    const modalDialog = findingsModal.querySelector('.modal-dialog');
    if (modalDialog) {
        modalDialog.style.position = 'fixed';
        modalDialog.style.top = '50%';
        modalDialog.style.left = '50%';
        modalDialog.style.transform = 'translate(-50%, -50%)';
        modalDialog.style.margin = '0';
        modalDialog.style.maxWidth = '600px';
        modalDialog.style.width = '95%';
        modalDialog.style.zIndex = '1061';
        modalDialog.style.boxShadow = '0 5px 15px rgba(0,0,0,0.3)';
    }

    // Initialize Bootstrap modal
    if (!bootstrap.Modal.getInstance(findingsModal)) {
        const bsModal = new bootstrap.Modal(findingsModal, {
            backdrop: false,
            keyboard: true
        });
    }

    // Add event listener for modal hidden event
    findingsModal.addEventListener('hidden.bs.modal', function () {
        // Hide findings modal
        findingsModal.style.display = 'none';
        findingsModal.classList.remove('show');
        findingsModal.setAttribute('aria-hidden', 'true');
        findingsModal.removeAttribute('aria-modal');
        findingsModal.removeAttribute('role');
        
        // Show charge slip modal
        chargeSlipModal.style.display = 'block';
        chargeSlipModal.classList.add('show');
        chargeSlipModal.style.opacity = '1';
        chargeSlipModal.removeAttribute('aria-hidden');
        chargeSlipModal.setAttribute('aria-modal', 'true');
        chargeSlipModal.setAttribute('role', 'dialog');
        document.body.classList.add('modal-open');
        
        // Remove any backdrops
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
    });

    // Show the modal
    const modal = bootstrap.Modal.getInstance(findingsModal) || new bootstrap.Modal(findingsModal);
    modal.show();

    // Handle save findings button click
    const saveButton = findingsModal.querySelector('.btn-primary');
    if (saveButton) {
        saveButton.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            saveFindings();
        };
    }

    // Add custom styles
    if (!document.getElementById('modal-custom-styles')) {
        const styleSheet = document.createElement('style');
        styleSheet.id = 'modal-custom-styles';
        styleSheet.textContent = `
            .modal {
                background: transparent !important;
            }
            .modal-backdrop {
                display: none !important;
            }
            #findingsModal .modal-dialog {
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            }
            #findingsModal.show .modal-dialog {
                animation: modalFadeIn 0.2s ease-out;
            }
            @keyframes modalFadeIn {
                from {
                    opacity: 0;
                    transform: translate(-50%, -60%);
                }
                to {
                    opacity: 1;
                    transform: translate(-50%, -50%);
                }
            }
            body.modal-open {
                overflow: hidden;
                padding-right: 0 !important;
            }
            #findingsModal .modal-content {
                pointer-events: auto;
            }
            #findingsModal input,
            #findingsModal textarea,
            #findingsModal select {
                z-index: 1062;
                position: relative;
            }
            #medicalRecordModal .modal-content {
                pointer-events: auto;
            }
            #medicalRecordModal input,
            #medicalRecordModal textarea,
            #medicalRecordModal select {
                pointer-events: auto;
                position: relative;
            }
            /* Hide chief complaint section */
            .chief-complaint,
            .chief-complaint-section {
                display: none !important;
            }
        `;
        document.head.appendChild(styleSheet);
    }

    // Make sure form fields are interactive
    const formFields = findingsModal.querySelectorAll('input, textarea, select');
    formFields.forEach(field => {
        field.style.pointerEvents = 'auto';
        field.style.position = 'relative';
        field.style.zIndex = '1062';
    });

    // Make charge slip fields interactive
    const chargeSlipFields = chargeSlipModal.querySelectorAll('input, textarea, select');
    chargeSlipFields.forEach(field => {
        field.style.pointerEvents = 'auto';
        field.style.position = 'relative';
    });
}

// Update the saveFindings function
function saveFindings() {
    const form = document.getElementById('findingsForm');
    const formData = new FormData(form);
    
    // Show loading state
    Swal.fire({
        title: 'Saving...',
        text: 'Please wait while we save your findings',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Get the user ID from the page
    const userId = document.querySelector('meta[name="user-id"]')?.content;
    
    fetch('/api/findings', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-User-Id': userId
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close the findings modal
            const findingsModal = document.getElementById('findingsModal');
            const bsModal = bootstrap.Modal.getInstance(findingsModal);
            if (bsModal) {
                bsModal.hide();
            }

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Findings have been saved successfully',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            throw new Error(data.message || 'Failed to save findings');
        }
    })
    .catch(error => {
        console.error('Error saving findings:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'There was an error saving the findings'
        });
    });
}

function viewFindingsHistory(appointmentId) {
    fetch(`/api/findings/${appointmentId}/history`)
        .then(response => response.json())
        .then(data => {
            const historyContent = document.getElementById('findingsHistoryContent');
            
            if (data.length === 0) {
                historyContent.innerHTML = '<div class="text-center text-muted">No findings recorded yet.</div>';
                return;
            }
            
            const findingsHtml = data.map(finding => `
                <div class="card mb-2">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="card-title mb-0 small">
                                <i class="fas fa-calendar-alt me-1"></i>
                                ${new Date(finding.created_at).toLocaleDateString()}
                            </h6>
                            <span class="badge bg-primary">${finding.type || 'Finding'}</span>
                        </div>
                        ${finding.findings_data ? `
                            <div class="findings-data small">
                                ${Object.entries(finding.findings_data).map(([key, value]) => `
                                    <div class="mb-1">
                                        <strong>${key}:</strong> 
                                        <span class="text-muted">${value}</span>
                            </div>
                                `).join('')}
                            </div>
                        ` : ''}
                        ${finding.notes ? `
                            <div class="mt-2 pt-2 border-top">
                                <small class="text-muted">${finding.notes}</small>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `).join('');
            
            historyContent.innerHTML = findingsHtml;
        })
        .catch(error => {
            console.error('Error fetching findings history:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load findings history'
            });
        });
    
    const modal = new bootstrap.Modal(document.getElementById('findingsHistoryModal'));
    modal.show();
} 