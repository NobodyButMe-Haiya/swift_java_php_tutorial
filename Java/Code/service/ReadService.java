package com.sponline.crud.service;

import android.util.Log;
import android.view.View;
import android.widget.TextView;

import androidx.fragment.app.FragmentActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.gson.Gson;
import com.sponline.crud.R;
import com.sponline.crud.adapter.ReadAdapter;
import com.sponline.crud.model.DataModel;
import com.sponline.crud.model.ReadModel;
import com.sponline.crud.model.SuccessModel;
import com.sponline.crud.model.FailureModel;
import com.sponline.crud.setting.NetworksConnection;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import cn.pedant.SweetAlert.SweetAlertDialog;

public class ReadService {
    private static final String TAG = ReadService.class.getName();

    private final View view;
    private final FragmentActivity fragmentActivity;
    private final ReadAdapter readAdapter;

    private final String URL;
    private RequestQueue requestQueue;

    public ReadService(View view1, FragmentActivity fragmentActivity1,ReadAdapter readAdapter1) {
        view = view1;
        fragmentActivity = fragmentActivity1;
        URL = NetworksConnection.SERVER.toString();
        readAdapter = readAdapter1;
    }

    public void execute(final String... strings) {
        // since we need more information
        Log.d(TAG, " Note value is " + strings[1] + " dialect value=" + strings[0]);

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
                params.put("mode", strings[0]);

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
     //   button.setClickable(true);

        try {
            new JSONObject(response);
            if (response.contains(error)) {
                final FailureModel FailureModel;
                FailureModel = new Gson().fromJson(response, FailureModel.class);


                new SweetAlertDialog(fragmentActivity, SweetAlertDialog.ERROR_TYPE)
                        .setTitleText(fragmentActivity.getString(R.string.serverErrorText))
                        .setContentText(FailureModel.getMessage())
                        .show();

            } else if (response.contains(success)) {
                final ReadModel readModel = new Gson().fromJson(response, ReadModel.class);

                List<DataModel> dataModels;

                if (readModel.getSuccess()) {
                    // Recheck sync model
                    dataModels = readModel.getDataModel();

                    if (dataModels.size() > 0) {
                        //bind the data to adapter
                        readAdapter.execute(dataModels);
                        readAdapter.notifyDataSetChanged();
                        Log.d(TAG, "Assign data to adapter");
                    } else {
                        // message to end user record not found.sweet android
                        Log.d(TAG, "record not found: CardTopUp history");
                        // don't leave empty white page..just give some information
                        TextView textView = view.findViewById(R.id.emptyRecordReload);
                        textView.setVisibility(View.VISIBLE);
                    }
                } else {
                    Log.d(TAG, "something wrong getting  list");
                }
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