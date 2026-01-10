package com.example.deisa.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.deisa.R
import com.example.deisa.models.Sakit

class SakitAdapter(private val onClick: (Sakit) -> Unit) : RecyclerView.Adapter<SakitAdapter.ViewHolder>() {

    private val list = mutableListOf<Sakit>()

    fun setData(newList: List<Sakit>) {
        list.clear()
        list.addAll(newList)
        notifyDataSetChanged()
    }

    inner class ViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val tvName: TextView = itemView.findViewById(R.id.tvName)
        val tvClass: TextView = itemView.findViewById(R.id.tvClass)
        val tvStatus: TextView = itemView.findViewById(R.id.tvStatus)
        val tvDate: TextView = itemView.findViewById(R.id.tvDate)

        fun bind(sakit: Sakit) {
            tvName.text = sakit.santri?.displayName() ?: "Unknown"
            tvClass.text = sakit.santri?.displayKelas() ?: "-"
            tvDate.text = sakit.displayDate()
            
            // Tingkat kondisi with color coding
            val tingkat = sakit.tingkatKondisi ?: sakit.status ?: "-"
            tvStatus.text = tingkat.replaceFirstChar { it.uppercase() }
            
            when (tingkat.lowercase()) {
                "ringan" -> {
                    tvStatus.setBackgroundResource(R.drawable.bg_status_sehat)
                    tvStatus.setTextColor(itemView.context.getColor(android.R.color.holo_green_dark))
                }
                "sedang" -> {
                    tvStatus.setBackgroundResource(R.drawable.bg_circle_orange_10)
                    tvStatus.setTextColor(itemView.context.getColor(android.R.color.holo_orange_dark))
                }
                "berat" -> {
                    tvStatus.setBackgroundResource(R.drawable.bg_status_sakit)
                    tvStatus.setTextColor(itemView.context.getColor(android.R.color.holo_red_dark))
                }
                else -> {
                    tvStatus.setBackgroundResource(R.drawable.bg_chip)
                    tvStatus.setTextColor(itemView.context.getColor(android.R.color.darker_gray))
                }
            }
            
            itemView.setOnClickListener { onClick(sakit) }
        }
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_sakit, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        holder.bind(list[position])
    }

    override fun getItemCount(): Int = list.size
}
