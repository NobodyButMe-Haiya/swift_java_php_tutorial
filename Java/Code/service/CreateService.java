package com.sponline.crud.service;

import android.util.Log;
import android.view.View;

import androidx.fragment.app.FragmentActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.gson.Gson;
import com.sponline.crud.R;
import com.sponline.crud.model.SuccessModel;
import com.sponline.crud.model.FailureModel;
import com.sponline.crud.setting.NetworksConnection;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class CreateService {
    private static final String TAG = CreateService.class.getName();

    private final View view;
    private final FragmentActivity fragmentActivity;
    private final String URL;
    private RequestQueue requestQueue;

    public CreateService(View view1, FragmentActivity fragmentActivity1) {
        view = view1;
        fragmentActivity = fragmentActivity1;
        URL = NetworksConnection.SERVER.toString();
    }

    public void execute(final String... strings) {
        // since we need more information
        Log.d(TAG, " Age value is " + strings[1] + " Name value=" + strings[0]);

        StringRequest stringRequest = new StringRequest(Request.Method.POST, URL,
                response -> {
                    requestQueue.getCache().clear();
                    Log.d(TAG, response);
                    getData(response);
                },
                error -> {
                    Log.d(TAG, error.toString());

                    new SweetAlertDialog(fragmentActivity, SweetAlertDialog.ERROR_TYPE)
                            .setTitleText(fragmentActivity.getString(R.string.app_name))
                            .setContentText(fragmentActivity.getString(R.string.errorText))
                            .show();

                }) {
            @Override
            protected Map<String, String> getParams() {

                final String ANDROID = "1";
                Map<String, String> params = new HashMap<>();
                params.put("name", strings[0]);
                params.put("age", strings[1]);
                params.put("mode", "create");
                return params;
            }
        };
        requestQueue = Volley.newRequestQueue(fragmentActivity);
        requestQueue.add(stringRequest);
    }

    private void getData(String response) {
        String error = "false";
        String success = "true";
        Log.d(TAG, "Raw :[" + response+"]");

      //  Button button = view.findViewById(R.id.requestSubmitButton);
      //  button.setText(fragmentActivity.getString(R.string.submit));
      //  button.setClickable(true);

        try {
            new JSONObject(response);
            if (response.contains(error)) {
                final FailureModel FailureModel;
                FailureModel = new Gson().fromJson(response, FailureModel.class);

                // return default english if not supported
                String errorMessage = FailureModel.getMessage();
                if (FailureModel.getCode() != null) {
                    if (Integer.parseInt(FailureModel.getCode()) == 1) {
                        errorMessage = fragmentActivity.getString(R.string.serverErrorText);
                    } else {
                        errorMessage = FailureModel.getMessage();
                    }
                }
                new SweetAlertDialog(fragmentActivity, SweetAlertDialog.ERROR_TYPE)
                        .setTitleText(fragmentActivity.getString(R.string.errorText))
                        .setContentText(errorMessage)
                        .show();

            } else if (response.contains(success)) {
                final SuccessModel SuccessModel = new Gson().fromJson(response, SuccessModel.class);
                Log.d(TAG, SuccessModel.toString());

                new SweetAlertDialog(fragmentActivity, SweetAlertDialog.SUCCESS_TYPE)
                        .setTitleText(fragmentActivity.getString(R.string.app_name))
                        .setContentText(fragmentActivity.getString(R.string.app_name))
                        .show();
            } else {
                Log.d(TAG, "unknown error");
            }
        } catch (JSONException ex) {
            Log.d(TAG, "JSON Error :[" + ex.getMessage() + "]");
            new SweetAlertDialog(fragmentActivity, SweetAlertDialog.ERROR_TYPE)
                    .setTitleText(fragmentActivity.getString(R.string.errorText))
                    .setContentText(fragmentActivity.getString(R.string.errorText))
                    .show();
        }
    }
}