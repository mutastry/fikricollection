@props([
    'name' => 'images',
    'label' => 'Upload Images',
    'multiple' => true,
    'maxFiles' => 10,
    'maxSize' => 2048, // KB
    'accept' => 'image/*',
    'existingImages' => [],
    'required' => false,
    'help' => null,
    'error' => null,
])

<div x-data="imageUpload({
    name: '{{ $name }}',
    multiple: {{ $multiple ? 'true' : 'false' }},
    maxFiles: {{ $maxFiles }},
    maxSize: {{ $maxSize }},
    accept: '{{ $accept }}',
    existingImages: {{ json_encode($existingImages) }},
    required: {{ $required ? 'true' : 'false' }}
})" class="space-y-4">
    <!-- Label -->
    <div class="flex items-center justify-between">
        <x-input-label :for="$name" :value="$label" :required="$required" />
        <span x-show="getTotalFileCount() > 0" class="text-sm text-gray-500"
            x-text="`${getTotalFileCount()}/${maxFiles} files`"></span>
    </div>

    <!-- Upload Area -->
    <div class="relative">
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors duration-200"
            :class="{
                'border-amber-400 bg-amber-50': isDragOver,
                'border-red-300 bg-red-50': hasError,
                'border-green-300 bg-green-50': getTotalFileCount() > 0 && !hasError
            }"
            @dragover.prevent="isDragOver = true" @dragleave.prevent="isDragOver = false"
            @drop.prevent="handleDrop($event)">

            <div class="space-y-4">
                <div class="mx-auto w-12 h-12 text-gray-400">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 48 48" aria-hidden="true">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <div>
                    <label :for="name + '_input'" class="cursor-pointer">
                        <span class="text-amber-600 font-medium hover:text-amber-500">Click to upload</span>
                        <span class="text-gray-500"> or drag and drop</span>
                    </label>
                    <input type="file" :id="name + '_input'" :name="multiple ? name + '[]' : name"
                        :accept="accept" :multiple="multiple" @change="handleFileSelect($event)" class="sr-only"
                        :required="required">
                </div>

                <div class="text-xs text-gray-500 space-y-1">
                    <p x-text="getAcceptedTypesText()"></p>
                    <p x-show="multiple" x-text="`Maximum ${maxFiles} files total`"></p>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div x-show="isProcessing"
            class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center rounded-lg">
            <div class="flex items-center space-x-2">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-amber-600"></div>
                <span class="text-sm text-gray-600">Processing files...</span>
            </div>
        </div>
    </div>

    <!-- Help Text -->
    @if ($help)
        <p class="text-sm text-gray-500">{{ $help }}</p>
    @endif

    <!-- Error Messages -->
    @if ($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif
    <div x-show="errorMessage" class="text-sm text-red-600" x-text="errorMessage"></div>

    <!-- Existing Images -->
    <div x-show="displayExistingImages.length > 0" class="space-y-3">
        <h4 class="text-sm font-medium text-gray-700">Current Images</h4>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <template x-for="(image, index) in displayExistingImages" :key="'existing-' + index">
                <div class="relative group">
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 border-gray-200">
                        <img :src="image.url" :alt="'Existing image ' + (index + 1)"
                            class="w-full h-full object-cover">
                    </div>
                    <button type="button" @click="removeExistingImage(index)"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                        ×
                    </button>
                </div>
            </template>
        </div>
    </div>

    <!-- New Images Preview -->
    <div x-show="selectedFiles.length > 0" class="space-y-3">
        <h4 class="text-sm font-medium text-gray-700">New Images</h4>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <template x-for="(file, index) in selectedFiles" :key="'new-' + file.id">
                <div class="relative group">
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 border-green-200">
                        <img :src="file.preview" :alt="file.name" class="w-full h-full object-cover">
                    </div>
                    <button type="button" @click="removeSelectedFile(index)"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                        ×
                    </button>
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1">
                        <div class="truncate" x-text="file.name"></div>
                        <div class="text-right" x-text="formatFileSize(file.size)"></div>
                    </div>
                    <div class="absolute top-1 left-1 bg-green-500 text-white text-xs px-1 rounded">
                        NEW
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Hidden input for removed existing images -->
    <template x-for="removedImage in removedExistingImages" :key="'removed-' + removedImage">
        <input type="hidden" name="remove_existing_images[]" :value="removedImage">
    </template>
</div>

<script>
    function imageUpload(config) {
        return {
            // Configuration
            name: config.name,
            multiple: config.multiple,
            maxFiles: config.maxFiles,
            maxSize: config.maxSize * 1024, // Convert to bytes
            accept: config.accept,
            required: config.required,

            // State
            selectedFiles: [],
            displayExistingImages: [...(config.existingImages || [])],
            removedExistingImages: [],
            isDragOver: false,
            isProcessing: false,
            errorMessage: '',
            hasError: false,
            fileIdCounter: 0,

            init() {
                // Initialize component
                this.$nextTick(() => {
                    this.updateFileInput();
                });
            },

            handleFileSelect(event) {
                this.processFiles(Array.from(event.target.files));
                // Clear the input to allow selecting the same file again
                event.target.value = '';
            },

            handleDrop(event) {
                this.isDragOver = false;
                this.processFiles(Array.from(event.dataTransfer.files));
            },

            processFiles(files) {
                this.clearError();
                this.isProcessing = true;

                // Check total file count
                const totalFiles = this.getTotalFileCount() + files.length;
                if (totalFiles > this.maxFiles) {
                    this.showError(
                        `Maximum ${this.maxFiles} files allowed. You're trying to add ${files.length} more files.`);
                    this.isProcessing = false;
                    return;
                }

                let processedCount = 0;
                const totalToProcess = files.length;

                files.forEach(file => {
                    // Validate file type
                    if (!this.isValidFileType(file)) {
                        this.showError(
                            `File "${file.name}" is not a valid ${this.getAcceptedTypesText().toLowerCase()} file.`
                        );
                        processedCount++;
                        if (processedCount === totalToProcess) {
                            this.isProcessing = false;
                        }
                        return;
                    }

                    // Validate file size
                    if (file.size > this.maxSize) {
                        this.showError(
                            `File "${file.name}" is too large. Maximum size is ${this.formatFileSize(this.maxSize)}.`
                        );
                        processedCount++;
                        if (processedCount === totalToProcess) {
                            this.isProcessing = false;
                        }
                        return;
                    }

                    // Check for duplicates
                    const isDuplicate = this.selectedFiles.some(existingFile =>
                        existingFile.name === file.name && existingFile.size === file.size
                    );

                    if (isDuplicate) {
                        this.showError(`File "${file.name}" is already selected.`);
                        processedCount++;
                        if (processedCount === totalToProcess) {
                            this.isProcessing = false;
                        }
                        return;
                    }

                    // Create preview
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.selectedFiles.push({
                            id: ++this.fileIdCounter,
                            file: file,
                            name: file.name,
                            size: file.size,
                            preview: e.target.result
                        });

                        processedCount++;
                        if (processedCount === totalToProcess) {
                            this.isProcessing = false;
                            this.updateFileInput();
                        }
                    };
                    reader.readAsDataURL(file);
                });
            },

            removeSelectedFile(index) {
                const file = this.selectedFiles[index];
                // Revoke object URL to free memory
                if (file.preview && file.preview.startsWith('blob:')) {
                    URL.revokeObjectURL(file.preview);
                }
                this.selectedFiles.splice(index, 1);
                this.updateFileInput();
            },

            removeExistingImage(index) {
                const removedImage = this.displayExistingImages[index];
                this.removedExistingImages.push(removedImage.url);
                this.displayExistingImages.splice(index, 1);
            },

            updateFileInput() {
                const fileInput = document.getElementById(this.name + '_input');
                if (!fileInput) return;

                if (this.selectedFiles.length === 0) {
                    fileInput.value = '';
                    return;
                }

                // Create new FileList with selected files
                const dt = new DataTransfer();
                this.selectedFiles.forEach(fileData => {
                    dt.items.add(fileData.file);
                });
                fileInput.files = dt.files;
            },

            isValidFileType(file) {
                if (this.accept === 'image/*') {
                    return file.type.startsWith('image/');
                }

                const acceptedTypes = this.accept.split(',').map(type => type.trim());
                return acceptedTypes.some(type => {
                    if (type === 'image/*') return file.type.startsWith('image/');
                    if (type === 'application/pdf') return file.type === 'application/pdf';
                    return file.type === type;
                });
            },

            getAcceptedTypesText() {
                if (this.accept === 'image/*') {
                    return 'PNG, JPG, GIF up to ' + this.formatFileSize(this.maxSize);
                }
                if (this.accept.includes('application/pdf')) {
                    return 'Images and PDFs up to ' + this.formatFileSize(this.maxSize);
                }
                return 'Accepted files up to ' + this.formatFileSize(this.maxSize);
            },

            getTotalFileCount() {
                return this.selectedFiles.length + this.displayExistingImages.length;
            },

            showError(message) {
                this.errorMessage = message;
                this.hasError = true;
                setTimeout(() => {
                    this.clearError();
                }, 5000);
            },

            clearError() {
                this.errorMessage = '';
                this.hasError = false;
            },

            formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        };
    }
</script>
