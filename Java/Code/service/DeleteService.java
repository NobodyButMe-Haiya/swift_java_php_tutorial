package com.sponline.crud.service;

import android.util.Log;
import android.view.View;

import androidx.fragment.app.FragmentActivity;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.gson.Gson;
import com.sponline.crud.R;
import com.sponline.crud.adapter.ReadAdapter;
import com.sponline.crud.model.SuccessModel;
import com.sponline.crud.model.FailureModel;
import com.sponline.crud.setting.NetworksConnection;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;
import java.util.Objects;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class DeleteService {
    private static final String TAG = DeleteService.class.getName();

    private final View view;
    private final FragmentActivity fragmentActivity;
    private final String URL;
    private RequestQueue requestQueue;
    private Integer position;
    private ReadAdapter readAdapter;
    public DeleteService(View view1, FragmentActivity fragmentActivity1,Integer position1,ReadAdapter readAdapter1) {
        view = view1;
        fragmentActivity = fragmentActivity1;
        URL = NetworksConnection.SERVER.toString();
        position = position1;
        readAdapter  = readAdapter1;
    }

    public void execute(final String... strings) {
        // since we need more information
        Log.d(TAG, " personId=" + strings[0]);

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

                Map<String, String> params = new HashMap<>();
                params.put("personId", strings[0]);
                params.put("mode", "delete");

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
     //   button.setText(fragmentActivity.getString(R.string.submit));
      //  button.setClickable(true);

        try {
            new JSONObject(response);
            if (response.contains(error)) {
                final FailureModel failureModel;
                failureModel = new Gson().fromJson(response, FailureModel.class);

                // return default english if not supported
                String errorMessage = failureModel.getMessage();
                if (failureModel.getCode() != null) {
                    if (Integer.parseInt(failureModel.getCode()) == 1) {
                        errorMessage = fragmentActivity.getString(R.string.serverErrorText);
                    } else {
                        errorMessage = failureModel.getMessage();
                    }
                }
                new SweetAlertDialog(fragmentActivity, SweetAlertDialog.ERROR_TYPE)
                        .setTitleText(fragmentActivity.getString(R.string.errorText))
                        .setContentText(errorMessage)
                        .show();

            } else if (response.contains(success)) {
                final SuccessModel SuccessModel = new Gson().fromJson(response, SuccessModel.class);
                Log.d(TAG, SuccessModel.toString());
                // remove from adapter if complete
                readAdapter.removeItem(position);
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