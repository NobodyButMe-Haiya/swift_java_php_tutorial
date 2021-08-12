package com.sponline.crud.model;

public class ReadModel {
    private Boolean success;
    private String code;
    private DataModel dataModel;

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

    public DataModel getDataModel() {
        return dataModel;
    }

    public void setDataModel(DataModel dataModel) {
        this.dataModel = dataModel;
    }

    @Override
    public String toString() {
        return "ReadModel{" +
                "success=" + success +
                ", code='" + code + '\'' +
                ", dataModel=" + dataModel +
                '}';
    }
}
