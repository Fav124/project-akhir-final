package com.example.deisa.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.R
import com.example.deisa.models.Diagnosis

class DiagnosisAdapter(
    private var list: List<Diagnosis>,
    private val onEdit: (Diagnosis) -> Unit,
    private val onDelete: (Diagnosis) -> Unit
) : RecyclerView.Adapter<DiagnosisAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tvNamaPenyakit: TextView = view.findViewById(R.id.tvNamaPenyakit)
        val tvId: TextView = view.findViewById(R.id.tvId)
        val btnEdit: ImageView = view.findViewById(R.id.btnEdit)
        val btnDelete: ImageView = view.findViewById(R.id.btnDelete)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_diagnosis, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val item = list[position]
        holder.tvNamaPenyakit.text = item.namaPenyakit
        holder.tvId.text = "ID: #${item.id}"

        holder.btnEdit.setOnClickListener { onEdit(item) }
        holder.btnDelete.setOnClickListener { onDelete(item) }
    }

    override fun getItemCount() = list.size

    fun updateList(newList: List<Diagnosis>) {
        list = newList
        notifyDataSetChanged()
    }
}
