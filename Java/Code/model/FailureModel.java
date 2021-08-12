package com.sponline.crud.model;

public class FailureModel {
    private Boolean success;
    private String code;
    private String message;

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

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    @Override
    public String toString() {
        return "FailureModel{" +
                "success=" + success +
                ", code='" + code + '\'' +
                ", message='" + message + '\'' +
                '}';
    }
}
