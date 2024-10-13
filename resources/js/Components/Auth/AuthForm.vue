<template>
    <form
        class="p-4 flex flex-col justify-center items-center gap-3 bg-base-100 bg-opacity-70 rounded-md w-full max-w-screen-sm md:max-w-none"
    >
        <slot />
        <div class="w-full flex items-center justify-center">
            <button class="btn btn-primary w-40">Submit</button>
        </div>
    </form>
</template>
