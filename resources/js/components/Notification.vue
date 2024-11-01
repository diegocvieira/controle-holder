<template>
    <div :class="{'notification': true, 'success': success}" v-if="isOpen">
        <div class="notification__content">
            <div class="notification__content__background"></div>
            <div class="notification__content__icon">
                <svg v-if="success" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 500" width="500" height="500" preserveAspectRatio="xMidYMid meet" style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px); content-visibility: visible;"><defs><clipPath id="__lottie_element_4422"><rect width="500" height="500" x="0" y="0"></rect></clipPath><clipPath id="__lottie_element_4425"><path d="M0,0 L500,0 L500,500 L0,500z"></path></clipPath><g id="__lottie_element_4434"><g clip-path="url(#__lottie_element_4435)" style="display: block;" transform="matrix(1,0,0,1,0,0)" opacity="1"><g class="primary design" style="display: block;" transform="matrix(1,0,0,1,253.41900634765625,260.34698486328125)" opacity="1"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0" class="primary" stroke="rgb(168,231,166)" stroke-opacity="1" stroke-width="41" d=" M84.03399658203125,-62.37699890136719 C32.19599914550781,-10.815999984741211 -31.320999145507812,52.36199951171875 -31.320999145507812,52.36199951171875 C-31.320999145507812,52.36199951171875 -72.36100006103516,11.373000144958496 -81.67500305175781,2.069999933242798"></path></g></g><g class="primary design" style="display: block;" transform="matrix(1,0,0,1,253.41900634765625,260.34698486328125)" opacity="1"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0" class="primary" stroke="rgb(168,231,166)" stroke-opacity="1" stroke-width="41" d="M0 0"></path></g></g></g></g><clipPath id="__lottie_element_4435"><path d="M0,0 L500,0 L500,500 L0,500z"></path></clipPath><filter id="__lottie_element_4447" filterUnits="objectBoundingBox" x="0%" y="0%" width="100%" height="100%"><feComponentTransfer in="SourceGraphic"><feFuncA type="table" tableValues="1.0 0.0"></feFuncA></feComponentTransfer></filter><mask id="__lottie_element_4434_2" mask-type="alpha"><g filter="url(#__lottie_element_4447)"><rect width="500" height="500" x="0" y="0" fill="#ffffff" opacity="0"></rect><use xlink:href="#__lottie_element_4434"></use></g></mask></defs><g clip-path="url(#__lottie_element_4422)"><g clip-path="url(#__lottie_element_4425)" transform="matrix(1,0,0,1,0,0)" opacity="1" style="display: block;"><g mask="url(#__lottie_element_4434_2)" style="display: block;"><g class="primary design" transform="matrix(-1,0,0,-1,250.00399780273438,250.0030059814453)" opacity="1"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0" class="primary" stroke="rgb(168,231,166)" stroke-opacity="1" stroke-width="31.3" d=" M192.65199279785156,-4.656000137329102 C195.2239990234375,101.74299621582031 111.05500030517578,190.0800018310547 4.656000137329102,192.65199279785156 C-101.74299621582031,195.2239990234375 -190.0800018310547,111.05500030517578 -192.65199279785156,4.656000137329102 C-195.2239990234375,-101.74299621582031 -111.05500030517578,-190.0800018310547 -4.656000137329102,-192.65199279785156 C101.74299621582031,-195.2239990234375 190.0800018310547,-111.05500030517578 192.65199279785156,-4.656000137329102z"></path><path class="primary" fill="rgb(168,231,166)" fill-opacity="1" d=" M192.65199279785156,-4.656000137329102 C195.2239990234375,101.74299621582031 111.05500030517578,190.0800018310547 4.656000137329102,192.65199279785156 C-101.74299621582031,195.2239990234375 -190.0800018310547,111.05500030517578 -192.65199279785156,4.656000137329102 C-195.2239990234375,-101.74299621582031 -111.05500030517578,-190.0800018310547 -4.656000137329102,-192.65199279785156 C101.74299621582031,-195.2239990234375 190.0800018310547,-111.05500030517578 192.65199279785156,-4.656000137329102z"></path></g></g></g></g></g></svg>

                <svg v-else xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 500" width="500" height="500" preserveAspectRatio="xMidYMid meet" style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px); content-visibility: visible;"><defs><clipPath id="__lottie_element_3116"><rect width="500" height="500" x="0" y="0"></rect></clipPath><clipPath id="__lottie_element_3119"><path d="M0,0 L500,0 L500,500 L0,500z"></path></clipPath><g id="__lottie_element_3128"><g clip-path="url(#__lottie_element_3129)" style="display: block;" transform="matrix(1,0,0,1,0,0)" opacity="1"><g class="primary design" style="display: block;" transform="matrix(0.021420439705252647,0.9997705817222595,-0.9997705817222595,0.021420439705252647,250.00399780273438,250.0030059814453)" opacity="1"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0" stroke="rgb(0,0,0)" stroke-opacity="1" stroke-width="41" d=" M67.70899963378906,67.70899963378906 C67.70899963378906,67.70899963378906 -67.70899963378906,-67.70899963378906 -67.70899963378906,-67.70899963378906"></path></g></g><g style="display: block;" transform="matrix(0.17509573698043823,0.9845514297485352,-0.9845514297485352,0.17509573698043823,250.00399780273438,250.0030059814453)" opacity="1"><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0" stroke="rgb(0,0,0)" stroke-opacity="1" stroke-width="41" d=" M-67.70899963378906,67.70899963378906 C-67.70899963378906,67.70899963378906 67.70899963378906,-67.70899963378906 67.70899963378906,-67.70899963378906"></path></g></g></g></g><clipPath id="__lottie_element_3129"><path d="M0,0 L500,0 L500,500 L0,500z"></path></clipPath><filter id="__lottie_element_3141" filterUnits="objectBoundingBox" x="0%" y="0%" width="100%" height="100%"><feComponentTransfer in="SourceGraphic"><feFuncA type="table" tableValues="1.0 0.0"></feFuncA></feComponentTransfer></filter><mask id="__lottie_element_3128_2" mask-type="alpha"><g filter="url(#__lottie_element_3141)"><rect width="500" height="500" x="0" y="0" fill="#ffffff" opacity="0"></rect><use xlink:href="#__lottie_element_3128"></use></g></mask></defs><g clip-path="url(#__lottie_element_3116)"><g clip-path="url(#__lottie_element_3119)" transform="matrix(1,0,0,1,0,0)" opacity="1" style="display: block;"><g mask="url(#__lottie_element_3128_2)" style="display: block;"><g transform="matrix(-1,0,0,-1,250.00399780273438,250.0030059814453)" opacity="1"><path fill="rgb(210,82,82)" fill-opacity="1" d=" M192.65199279785156,-4.656000137329102 C195.2239990234375,101.74299621582031 111.05500030517578,190.0800018310547 4.656000137329102,192.65199279785156 C-101.74299621582031,195.2239990234375 -190.0800018310547,111.05500030517578 -192.65199279785156,4.656000137329102 C-195.2239990234375,-101.74299621582031 -111.05500030517578,-190.0800018310547 -4.656000137329102,-192.65199279785156 C101.74299621582031,-195.2239990234375 190.0800018310547,-111.05500030517578 192.65199279785156,-4.656000137329102z"></path><g opacity="1" transform="matrix(1,0,0,1,0,0)"><path stroke-linecap="round" stroke-linejoin="round" fill-opacity="0" stroke="rgb(210,82,82)" stroke-opacity="1" stroke-width="31.3" d=" M192.65199279785156,-4.656000137329102 C195.2239990234375,101.74299621582031 111.05500030517578,190.0800018310547 4.656000137329102,192.65199279785156 C-101.74299621582031,195.2239990234375 -190.0800018310547,111.05500030517578 -192.65199279785156,4.656000137329102 C-195.2239990234375,-101.74299621582031 -111.05500030517578,-190.0800018310547 -4.656000137329102,-192.65199279785156 C101.74299621582031,-195.2239990234375 190.0800018310547,-111.05500030517578 192.65199279785156,-4.656000137329102z"></path></g></g></g></g></g></svg>
            </div>

            <h3 class="notification__content__description">{{ description }}</h3>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpen: false,
            description: '',
            success: true,
            timeoutDuration: 5000
        }
    },
    methods: {
        show(description) {
            this.description = description;
            this.isOpen = true;

            this.autoClose();
        },
        autoClose() {
            setTimeout(() => {
                this.isOpen = false;
            }, this.timeoutDuration);
        },
        showSuccess(description) {
            this.setStatus(true, description);
        },
        showError(description) {
            this.setStatus(false, description);
        },
        setStatus(success, description) {
            this.success = success;
            this.show(description);
        }
    }
};
</script>
