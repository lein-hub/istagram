<template lang="">
    <div class="card mt-4">
        <div class="card-header">
            New Post
        </div>
        <div class="card-body">
            <div v-if="status_msg" :class="{'alert-success': status, 'alert-danger': !status}" class="alert" role="alert">
                {{ status_msg }}
            </div>
            <form>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Title</label>
                    <textarea v-model="content" class="form-control" id="post-content" rows="3" required></textarea>
                </div>
                <div>
                    <el-upload action="/" list-type="picture-card"
                        :on-preview="handlePictureCardPreview"
                        :on-change="updateImageList"
                        :auto-upload="false">
                        <i class="el-icon-plus"></i>
                    </el-upload>
                    <el-dialog :visible.sync="dialogVisible">
                        <img width="100%" :src="dialogImageUrl" alt="">
                    </el-dialog>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="button" @click="createPost" class="btn btn-success">
                {{ isCreateingPost ? 'Posting...' : 'Create Post' }}
            </button>
        </div>
    </div>
</template>
<script>
export default {

}
</script>
<style lang="">
/* .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.avatar-uploader .el-upload:hover {
    border-color: #409EFF;
}

.avater-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
}

.avatar {
    width: 178px;
    height: 178px;
    display: block;
} */


</style>
