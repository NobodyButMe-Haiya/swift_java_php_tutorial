package com.sponline.crud.model;
import androidx.annotation.NonNull;
public class SuccessModel {
   private Boolean success;
   private String code;

    public Boolean getSuccess() {
        return success;
    }

    public void setSuccess(Boolean success) {
        this.success = success;
    }

    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }

    @Override
    public String toString() {
        return "SuccessModel{" +
                "success=" + success +
                ", code='" + code + '\'' +
                '}';
    }
}
