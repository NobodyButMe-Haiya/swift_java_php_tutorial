package com.sponline.crud.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.sponline.crud.R;
import com.sponline.crud.model.DataModel;

import java.util.List;

public class ReadAdapter extends RecyclerView.Adapter<ReadAdapter.ReadAdapterViewHolder> {
    private static final String TAG = ReadAdapter.class.getName();

    private List<? extends DataModel> dataModels;

    private final Context context;

    public ReadAdapter(Context context1) {
        context = context1;

        DataModel dataModel = new DataModel();

    }

    public void execute(List<DataModel> DataModels1) {
        dataModels = DataModels1;
    }

    @NonNull
    @Override
    public ReadAdapter.ReadAdapterViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        LayoutInflater inflater = LayoutInflater.from(parent.getContext());
        return new ReadAdapter.ReadAdapterViewHolder(inflater.inflate(R.layout.list_layout, parent, false));
    }

    @Override
    public void onBindViewHolder(@NonNull ReadAdapter.ReadAdapterViewHolder holder, final int position) {

        holder.Name.setText(dataModels.get(position).getName());
        holder.Age.setText(dataModels.get(position).getAge());
    }

    public int getItemCount() {
        return dataModels == null ? 0 : dataModels.size();
    }

    static class ReadAdapterViewHolder extends RecyclerView.ViewHolder {

        private final TextView Name;
        private final TextView Age;
        ReadAdapterViewHolder(View view) {
            super(view);
            Name = itemView.findViewById(R.id.name);
            Age = itemView.findViewById(R.id.age);
        }

    }
}
