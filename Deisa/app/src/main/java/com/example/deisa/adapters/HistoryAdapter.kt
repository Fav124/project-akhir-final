package com.example.deisa.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.R
import com.example.deisa.models.ActivityLog

class HistoryAdapter(
    private var list: List<ActivityLog>
) : RecyclerView.Adapter<HistoryAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tvAction: TextView = view.findViewById(R.id.tvAction)
        val tvDate: TextView = view.findViewById(R.id.tvDate)
        val tvDescription: TextView = view.findViewById(R.id.tvDescription)
        val tvUser: TextView = view.findViewById(R.id.tvUser)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_history, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val item = list[position]
        holder.tvAction.text = item.action ?: "LOG"
        holder.tvDate.text = item.createdAt ?: "-"
        holder.tvDescription.text = item.description ?: ""
        holder.tvUser.text = "By: ${item.user?.name ?: "Unknown"}"
    }

    override fun getItemCount() = list.size

    fun updateList(newList: List<ActivityLog>) {
        list = newList
        notifyDataSetChanged()
    }
}
