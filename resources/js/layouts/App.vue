<template>
    <div>
        <div>
            <router-link :to="{name:'home'}">Home</router-link>
            <router-link :to="{name:'login'}">Login</router-link>
            <router-link :to="{name:'register'}">Register</router-link>
        </div>
        <router-view></router-view>
    </div>
</template>