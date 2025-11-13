<style>
    .profile-picture-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
    }
    
    .profile-preview-container {
        position: relative;
        width: 120px;
        height: 120px;
    }
    
    .profile-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .profile-initials {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .upload-controls {
        flex: 1;
    }
    
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }
    
    .file-input-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .file-input-label:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
    }
    
    .file-input-label i {
        font-size: 1.2rem;
    }
    
    .file-input-wrapper input[type="file"] {
        position: absolute;
        left: -9999px;
    }
    
    .upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 2rem;
        background: white;
        color: #667eea;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }
    
    .remove-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.25rem;
        background: rgba(239, 68, 68, 0.2);
        color: white;
        border: 2px solid rgba(239, 68, 68, 0.5);
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .remove-btn:hover {
        background: rgba(239, 68, 68, 0.3);
        border-color: rgba(239, 68, 68, 0.7);
    }
    
    .file-info {
        font-size: 0.85rem;
        opacity: 0.9;
        margin-top: 0.5rem;
    }
    
    .success-message {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(16, 185, 129, 0.2);
        border: 2px solid rgba(16, 185, 129, 0.5);
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
    }
</style>

<section class="profile-picture-section">
    <div class="mb-4">
        <h2 class="text-xl font-bold mb-1">
            <i class="bi bi-person-circle me-2"></i>Profile Picture
        </h2>
        <p class="text-sm opacity-90">
            Upload or update your profile picture (300x300px)
        </p>
    </div>

    <form method="post" action="{{ route('profile.picture.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <!-- Current Profile Picture -->
            <div class="profile-preview-container">
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                         alt="Profile Picture" 
                         class="profile-preview"
                         id="profilePreview">
                @else
                    <div class="profile-initials" id="profilePreview">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                @endif
            </div>

            <!-- Upload Controls -->
            <div class="upload-controls">
                <div class="mb-4">
                    <div class="file-input-wrapper">
                        <label for="profile_picture" class="file-input-label">
                            <i class="bi bi-cloud-upload"></i>
                            <span id="file-name">Choose a picture</span>
                        </label>
                        <input type="file" 
                               id="profile_picture" 
                               name="profile_picture" 
                               accept="image/*"
                               onchange="previewImage(event)">
                    </div>
                    <p class="file-info">
                        <i class="bi bi-info-circle me-1"></i>JPG, PNG or GIF (MAX. 2MB)
                    </p>
                </div>

                @if($errors->has('profile_picture'))
                    <div class="mb-3 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                        {{ $errors->first('profile_picture') }}
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="upload-btn">
                        <i class="bi bi-upload"></i>
                        Upload Picture
                    </button>

                    @if($user->profile_picture)
                        <button type="button" 
                                onclick="if(confirm('Remove profile picture?')) document.getElementById('remove-picture-form').submit()"
                                class="remove-btn">
                            <i class="bi bi-trash"></i>
                            Remove
                        </button>
                    @endif

                    @if (session('status') === 'picture-updated')
                        <div class="success-message"
                             x-data="{ show: true }"
                             x-show="show"
                             x-transition
                             x-init="setTimeout(() => show = false, 3000)">
                            <i class="bi bi-check-circle"></i>
                            Picture updated!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <!-- Hidden form for removing picture -->
    @if($user->profile_picture)
    <form id="remove-picture-form" method="post" action="{{ route('profile.picture.destroy') }}" style="display: none;">
        @csrf
        @method('delete')
    </form>
    @endif
</section>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('profilePreview');
    const fileName = document.getElementById('file-name');
    
    if (file) {
        // Update file name display
        fileName.textContent = file.name;
        
        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                // Replace div with img
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Profile Picture';
                img.className = 'profile-preview';
                img.id = 'profilePreview';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(file);
    }
}
</script>
