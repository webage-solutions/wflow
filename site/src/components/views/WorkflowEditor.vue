<template>
    <div class="container-fluid">
        <h1>Workflow Editor</h1>
        <div class="row">
            <div class="col-2">
                <button type="button" class="btn btn-primary btn-sm">
                    <fa icon="angle-double-left"/>
                </button>
            </div>
            <div class="col-7">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Graphical</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Json</a>
                    </li>
                </ul>
            </div>
            <div class="col-3">
                details view
            </div>
        </div>
    </div>
</template>

<script>
    import {library} from '@fortawesome/fontawesome-svg-core'
    import {faAngleDoubleLeft} from '@fortawesome/free-solid-svg-icons'
    library.add(faAngleDoubleLeft);

    export default {};
</script>

<style scoped>

</style>